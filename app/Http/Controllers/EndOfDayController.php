<?php

namespace App\Http\Controllers;

use App\Models\PlaySession;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class EndOfDayController extends Controller
{
    protected $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    /**
     * Show the end of day statistics page
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Trebuie să fiți autentificat');
        }

        // Get tenant - super admin can see all, others see their tenant
        $tenantId = null;
        if (!$user->isSuperAdmin() && $user->tenant) {
            $tenantId = $user->tenant->id;
        }

        // Get today's date range
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();

        // Get all sessions started today
        $sessionsQuery = PlaySession::where('started_at', '>=', $startOfDay)
            ->where('started_at', '<=', $endOfDay);

        if ($tenantId) {
            $sessionsQuery->where('tenant_id', $tenantId);
        }

        $sessionsToday = $sessionsQuery->get();

        // Calculate statistics
        $totalSessions = $sessionsToday->count();
        $birthdaySessions = $sessionsToday->where('is_birthday', true)->count();
        
        // Calculate total money (from ended sessions with calculated price)
        $endedSessions = $sessionsToday->whereNotNull('ended_at')->whereNotNull('calculated_price');
        $totalMoney = $endedSessions->sum('calculated_price');

        // Calculate total billed hours
        $totalBilledHours = 0;
        foreach ($sessionsToday as $session) {
            if ($session->ended_at && !$session->is_birthday) {
                $durationInHours = $this->pricingService->getDurationInHours($session);
                $roundedHours = $this->pricingService->roundToHalfHour($durationInHours);
                $totalBilledHours += $roundedHours;
            }
        }

        return view('end-of-day.index', [
            'totalSessions' => $totalSessions,
            'birthdaySessions' => $birthdaySessions,
            'totalMoney' => $totalMoney,
            'totalBilledHours' => $totalBilledHours,
            'tenantId' => $tenantId,
        ]);
    }

    /**
     * Show non-fiscal report print page
     */
    public function printNonFiscalReport()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Trebuie să fiți autentificat');
        }

        // Get tenant - super admin can see all, others see their tenant
        $tenantId = null;
        if (!$user->isSuperAdmin() && $user->tenant) {
            $tenantId = $user->tenant->id;
        }

        // Get today's date range
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();

        // Get all sessions started today
        $sessionsQuery = PlaySession::where('started_at', '>=', $startOfDay)
            ->where('started_at', '<=', $endOfDay);

        if ($tenantId) {
            $sessionsQuery->where('tenant_id', $tenantId);
        }

        $sessionsToday = $sessionsQuery->get();

        // Calculate statistics
        $totalSessions = $sessionsToday->count();
        $birthdaySessions = $sessionsToday->where('is_birthday', true)->count();
        
        // Calculate total billed hours
        $totalBilledHours = 0;
        foreach ($sessionsToday as $session) {
            if ($session->ended_at && !$session->is_birthday) {
                $durationInHours = $this->pricingService->getDurationInHours($session);
                $roundedHours = $this->pricingService->roundToHalfHour($durationInHours);
                $totalBilledHours += $roundedHours;
            }
        }

        // Format hours for display
        $hoursInt = floor($totalBilledHours);
        $minutesInt = round(($totalBilledHours - $hoursInt) * 60);
        if ($minutesInt >= 60) {
            $hoursInt += 1;
            $minutesInt = 0;
        }
        $totalHoursFormatted = $hoursInt . 'h';
        if ($minutesInt > 0) {
            $totalHoursFormatted .= ' ' . $minutesInt . 'm';
        }

        return view('end-of-day.print-non-fiscal', [
            'totalSessions' => $totalSessions,
            'birthdaySessions' => $birthdaySessions,
            'totalHoursFormatted' => $totalHoursFormatted,
            'date' => Carbon::today()->format('d.m.Y'),
        ]);
    }

    /**
     * Generate Z Report via bridge
     */
    public function printZReport(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Neautentificat'
            ], 401);
        }

        try {
            // Send request to bridge
            $bridgeUrl = config('services.fiscal_bridge.url', 'http://localhost:9000');
            $response = Http::timeout(10)->post($bridgeUrl . '/z-report');

            if (!$response->successful()) {
                throw new \Exception('Nu s-a putut conecta la bridge-ul fiscal');
            }

            $bridgeData = $response->json();

            if (!$bridgeData || ($bridgeData['status'] ?? '') !== 'success') {
                throw new \Exception($bridgeData['message'] ?? 'Eroare de la bridge-ul fiscal');
            }

            return response()->json([
                'success' => true,
                'message' => 'Raportul Z a fost generat cu succes',
                'file' => $bridgeData['file'] ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Eroare la generarea raportului Z: ' . $e->getMessage(),
            ], 500);
        }
    }
}

