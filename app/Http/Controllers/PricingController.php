<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\WeeklyRate;
use App\Models\SpecialPeriodRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PricingController extends Controller
{
    /**
     * Check if user has access to pricing management
     * SUPER_ADMIN can manage all tenants, COMPANY_ADMIN can manage only their own tenant
     */
    private function checkPricingAccess()
    {
        $user = Auth::user();
        if (!$user || (!$user->isSuperAdmin() && !$user->isCompanyAdmin())) {
            abort(403, 'Acces permis doar pentru super admin sau company admin');
        }
    }

    /**
     * Get the tenant ID for the current user
     * SUPER_ADMIN can select any tenant, COMPANY_ADMIN uses their own tenant
     */
    private function getTenantIdForUser($requestTenantId = null)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            // Super admin can select any tenant
            return $requestTenantId;
        } elseif ($user->isCompanyAdmin()) {
            // Company admin can only use their own tenant
            return $user->tenant_id;
        }
        
        return null;
    }

    /**
     * Ensure user can only access their own tenant's pricing
     */
    private function ensureTenantAccess($tenantId)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            // Super admin can access any tenant
            return;
        }
        
        if ($user->isCompanyAdmin() && $user->tenant_id != $tenantId) {
            abort(403, 'Nu aveți acces la acest tenant');
        }
    }

    /**
     * Display the pricing management page
     */
    public function index(Request $request)
    {
        $this->checkPricingAccess();

        $user = Auth::user();
        $tenantId = $this->getTenantIdForUser($request->get('tenant_id'));

        // For SUPER_ADMIN: show tenant selector
        // For COMPANY_ADMIN: automatically use their tenant
        $tenants = null;
        $selectedTenant = null;

        if ($user->isSuperAdmin()) {
            $tenants = Tenant::orderBy('name')->get();
            if ($tenantId) {
                $selectedTenant = Tenant::with(['weeklyRates', 'specialPeriodRates'])->findOrFail($tenantId);
            } elseif ($tenants->count() > 0) {
                $selectedTenant = Tenant::with(['weeklyRates', 'specialPeriodRates'])->find($tenants->first()->id);
            }
        } elseif ($user->isCompanyAdmin() && $user->tenant_id) {
            // Company admin: automatically use their tenant
            $selectedTenant = Tenant::with(['weeklyRates', 'specialPeriodRates'])->findOrFail($user->tenant_id);
        }

        return view('pricing.index', [
            'tenants' => $tenants,
            'selectedTenant' => $selectedTenant,
            'isSuperAdmin' => $user->isSuperAdmin(),
        ]);
    }

    /**
     * Show weekly rates form
     */
    public function showWeeklyRates(Request $request)
    {
        $this->checkPricingAccess();

        $tenantId = $this->getTenantIdForUser($request->get('tenant_id'));
        if (!$tenantId) {
            return redirect()->route('pricing.index')
                ->with('error', 'Selectați un tenant');
        }

        $tenant = Tenant::with('weeklyRates')->findOrFail($tenantId);
        $this->ensureTenantAccess($tenant->id);
        
        // Get existing rates indexed by day_of_week
        $weeklyRates = [];
        foreach ($tenant->weeklyRates as $rate) {
            $weeklyRates[$rate->day_of_week] = $rate->hourly_rate;
        }

        return view('pricing.weekly-rates', [
            'tenant' => $tenant,
            'weeklyRates' => $weeklyRates,
        ]);
    }

    /**
     * Update weekly rates
     */
    public function updateWeeklyRates(Request $request)
    {
        $this->checkPricingAccess();

        $tenantId = $this->getTenantIdForUser($request->tenant_id);
        if (!$tenantId) {
            return redirect()->route('pricing.index')
                ->with('error', 'Tenant invalid');
        }

        $request->validate([
            'rates' => 'required|array',
            'rates.*' => 'required|numeric|min:0',
        ]);

        $tenant = Tenant::findOrFail($tenantId);
        $this->ensureTenantAccess($tenant->id);

        DB::transaction(function () use ($tenant, $request) {
            // Update or create rates for each day
            for ($day = 0; $day <= 6; $day++) {
                $rate = $request->rates[$day] ?? null;
                if ($rate !== null) {
                    WeeklyRate::updateOrCreate(
                        [
                            'tenant_id' => $tenant->id,
                            'day_of_week' => $day,
                        ],
                        [
                            'hourly_rate' => $rate,
                        ]
                    );
                } else {
                    // Remove rate if not provided
                    WeeklyRate::where('tenant_id', $tenant->id)
                        ->where('day_of_week', $day)
                        ->delete();
                }
            }
        });

        $redirectParams = [];
        if (Auth::user()->isSuperAdmin()) {
            $redirectParams['tenant_id'] = $tenant->id;
        }

        return redirect()->route('pricing.index', $redirectParams)
            ->with('success', 'Tarifele săptămânale au fost actualizate cu succes');
    }

    /**
     * List special periods
     */
    public function indexSpecialPeriods(Request $request)
    {
        $this->checkPricingAccess();

        $tenantId = $this->getTenantIdForUser($request->get('tenant_id'));
        if (!$tenantId) {
            return redirect()->route('pricing.index')
                ->with('error', 'Selectați un tenant');
        }

        $tenant = Tenant::findOrFail($tenantId);
        $this->ensureTenantAccess($tenant->id);
        
        $specialPeriods = SpecialPeriodRate::where('tenant_id', $tenantId)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('pricing.special-periods', [
            'tenant' => $tenant,
            'specialPeriods' => $specialPeriods,
        ]);
    }

    /**
     * Store a new special period
     */
    public function storeSpecialPeriod(Request $request)
    {
        $this->checkPricingAccess();

        $tenantId = $this->getTenantIdForUser($request->tenant_id);
        if (!$tenantId) {
            return redirect()->route('pricing.index')
                ->with('error', 'Tenant invalid');
        }

        $this->ensureTenantAccess($tenantId);

        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'hourly_rate' => 'required|numeric|min:0',
        ]);

        // Check for overlapping periods
        $overlap = $this->checkSpecialPeriodOverlap(
            $tenantId,
            $request->start_date,
            $request->end_date
        );

        if ($overlap) {
            return back()->withInput()
                ->with('error', 'Există deja o perioadă specială care se suprapune cu perioada specificată');
        }

        try {
            SpecialPeriodRate::create([
                'tenant_id' => $tenantId,
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'hourly_rate' => $request->hourly_rate,
            ]);

            $redirectParams = [];
            if (Auth::user()->isSuperAdmin()) {
                $redirectParams['tenant_id'] = $tenantId;
            }

            return redirect()->route('pricing.special-periods', $redirectParams)
                ->with('success', 'Perioada specială a fost creată cu succes');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Eroare la crearea perioadei speciale: ' . $e->getMessage());
        }
    }

    /**
     * Update a special period
     */
    public function updateSpecialPeriod(Request $request, $id)
    {
        $this->checkPricingAccess();

        $specialPeriod = SpecialPeriodRate::findOrFail($id);
        $this->ensureTenantAccess($specialPeriod->tenant_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'hourly_rate' => 'required|numeric|min:0',
        ]);

        // Check for overlapping periods (excluding current one)
        $overlap = $this->checkSpecialPeriodOverlap(
            $specialPeriod->tenant_id,
            $request->start_date,
            $request->end_date,
            $id
        );

        if ($overlap) {
            return back()->withInput()
                ->with('error', 'Există deja o perioadă specială care se suprapune cu perioada specificată');
        }

        try {
            $specialPeriod->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'hourly_rate' => $request->hourly_rate,
            ]);

            $redirectParams = [];
            if (Auth::user()->isSuperAdmin()) {
                $redirectParams['tenant_id'] = $specialPeriod->tenant_id;
            }

            return redirect()->route('pricing.special-periods', $redirectParams)
                ->with('success', 'Perioada specială a fost actualizată cu succes');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Eroare la actualizarea perioadei speciale: ' . $e->getMessage());
        }
    }

    /**
     * Delete a special period
     */
    public function destroySpecialPeriod($id)
    {
        $this->checkPricingAccess();

        try {
            $specialPeriod = SpecialPeriodRate::findOrFail($id);
            $this->ensureTenantAccess($specialPeriod->tenant_id);
            
            $tenantId = $specialPeriod->tenant_id;
            $specialPeriod->delete();

            $redirectParams = [];
            if (Auth::user()->isSuperAdmin()) {
                $redirectParams['tenant_id'] = $tenantId;
            }

            return redirect()->route('pricing.special-periods', $redirectParams)
                ->with('success', 'Perioada specială a fost ștearsă cu succes');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Eroare la ștergerea perioadei speciale: ' . $e->getMessage());
        }
    }

    /**
     * Check if a date range overlaps with existing special periods
     * 
     * @param int $tenantId
     * @param string $startDate
     * @param string $endDate
     * @param int|null $excludeId Exclude this ID from check (for updates)
     * @return bool True if overlap exists
     */
    private function checkSpecialPeriodOverlap($tenantId, $startDate, $endDate, $excludeId = null)
    {
        $query = SpecialPeriodRate::where('tenant_id', $tenantId)
            ->where(function ($q) use ($startDate, $endDate) {
                // Check if new period overlaps with existing periods
                // Overlap exists if:
                // - existing start_date is between new start_date and end_date, OR
                // - existing end_date is between new start_date and end_date, OR
                // - new period is completely within an existing period
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}

