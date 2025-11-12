<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FiscalReceiptController extends Controller
{
    protected $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    /**
     * Check if user is super admin
     * Verifies that user is authenticated and has SUPER_ADMIN role
     */
    private function checkSuperAdmin()
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            abort(403, 'Trebuie să fiți autentificat');
        }
        
        // Ensure role relationship is loaded
        if (!isset($user->role)) {
            $user->load('role');
        }
        
        // Check if user has a role
        if (!$user->role) {
            abort(403, 'Utilizatorul nu are un rol asignat');
        }
        
        // Check if role is SUPER_ADMIN
        if ($user->role->name !== 'SUPER_ADMIN') {
            abort(403, 'Acces permis doar pentru super admin');
        }
    }

    /**
     * Show the fiscal receipt form
     */
    public function index()
    {
        $this->checkSuperAdmin();

        // Get all tenants for super admin to select
        $tenants = Tenant::where('is_active', true)->orderBy('name')->get();

        return view('fiscal-receipts.index', [
            'tenants' => $tenants,
        ]);
    }

    /**
     * Calculate price based on hours and minutes
     */
    public function calculatePrice(Request $request)
    {
        $this->checkSuperAdmin();

        $request->validate([
            'hours' => 'required|integer|min:0|max:24',
            'minutes' => 'required|integer|min:0|max:59',
            'tenant_id' => 'required|exists:tenants,id',
        ]);

        $tenant = Tenant::findOrFail($request->tenant_id);
        $hours = (int) $request->hours;
        $minutes = (int) $request->minutes;

        // Calculate total duration in hours
        $totalHours = $hours + ($minutes / 60);

        // Get hourly rate for the tenant (using current date)
        $hourlyRate = $this->pricingService->getHourlyRate($tenant, Carbon::now());

        // Round according to pricing rules
        $roundedHours = $this->pricingService->roundToHalfHour($totalHours);

        // Calculate price
        $price = round($roundedHours * $hourlyRate, 2);

        // Format duration for display
        $duration = $this->formatDuration($hours, $minutes);

        return response()->json([
            'success' => true,
            'price' => $price,
            'roundedHours' => $roundedHours,
            'hourlyRate' => $hourlyRate,
            'duration' => $duration,
        ]);
    }

    /**
     * Send fiscal receipt to bridge
     */
    public function print(Request $request)
    {
        $this->checkSuperAdmin();

        $request->validate([
            'hours' => 'required|integer|min:0|max:24',
            'minutes' => 'required|integer|min:0|max:59',
            'tenant_id' => 'required|exists:tenants,id',
            'paymentType' => 'required|in:CASH,CARD',
        ]);

        $tenant = Tenant::findOrFail($request->tenant_id);
        $hours = (int) $request->hours;
        $minutes = (int) $request->minutes;
        $paymentType = $request->paymentType;

        // Calculate total duration in hours
        $totalHours = $hours + ($minutes / 60);

        // Get hourly rate
        $hourlyRate = $this->pricingService->getHourlyRate($tenant, Carbon::now());

        // Round according to pricing rules
        $roundedHours = $this->pricingService->roundToHalfHour($totalHours);

        // Calculate price
        $price = round($roundedHours * $hourlyRate, 2);

        // Format duration for display
        $duration = $this->formatDuration($hours, $minutes);

        // Product name
        $productName = 'Ora de joacă';

        // Get bridge URL from config
        $bridgeUrl = config('services.fiscal_bridge.url', 'http://localhost:9000');

        try {
            // Send request to bridge
            $response = Http::timeout(15)->post("{$bridgeUrl}/print", [
                'productName' => $productName,
                'duration' => $duration,
                'price' => $price,
                'paymentType' => $paymentType,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['status'] === 'success') {
                    $fileName = $responseData['file'] ?? 'N/A';
                    $successMessage = "Bon fiscal emis cu succes!";
                    if ($fileName !== 'N/A') {
                        $successMessage .= " Fișier generat: {$fileName}";
                    }

                    Log::info('Fiscal receipt printed successfully', [
                        'user_id' => Auth::id(),
                        'tenant_id' => $tenant->id,
                        'tenant_name' => $tenant->name,
                        'price' => $price,
                        'duration' => $duration,
                        'payment_type' => $paymentType,
                        'file' => $fileName,
                    ]);

                    return redirect()->route('fiscal-receipts.index')
                        ->with('success', $successMessage)
                        ->with('receipt_details', [
                            'file' => $fileName,
                            'price' => $price,
                            'duration' => $duration,
                            'payment_type' => $paymentType,
                            'tenant' => $tenant->name,
                        ]);
                } else {
                    $errorMessage = $responseData['message'] ?? 'Eroare necunoscută';
                    $details = $responseData['details'] ?? '';
                    $fullErrorMessage = "Eroare la imprimare: {$errorMessage}";
                    if ($details) {
                        $fullErrorMessage .= " - Detalii: {$details}";
                    }

                    Log::error('Fiscal receipt print failed', [
                        'user_id' => Auth::id(),
                        'tenant_id' => $tenant->id,
                        'tenant_name' => $tenant->name,
                        'price' => $price,
                        'duration' => $duration,
                        'payment_type' => $paymentType,
                        'error' => $errorMessage,
                        'details' => $details,
                    ]);

                    return redirect()->route('fiscal-receipts.index')
                        ->with('error', $fullErrorMessage);
                }
            } else {
                $errorMessage = 'Eroare de comunicare cu bridge-ul fiscal';
                $statusCode = $response->status();
                $responseBody = $response->body();

                Log::error('Fiscal bridge communication error', [
                    'user_id' => Auth::id(),
                    'tenant_id' => $tenant->id,
                    'tenant_name' => $tenant->name,
                    'status_code' => $statusCode,
                    'response' => $responseBody,
                ]);

                $errorDetails = "Status HTTP: {$statusCode}";
                if ($statusCode === 504) {
                    $errorDetails .= " - Timeout: Bridge-ul nu a răspuns în timpul alocat";
                } elseif ($statusCode === 500) {
                    $errorDetails .= " - Eroare internă a bridge-ului";
                }

                return redirect()->route('fiscal-receipts.index')
                    ->with('error', "{$errorMessage}. {$errorDetails}");
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Fiscal bridge connection exception', [
                'user_id' => Auth::id(),
                'tenant_id' => $tenant->id,
                'tenant_name' => $tenant->name,
                'error' => $e->getMessage(),
                'bridge_url' => $bridgeUrl,
            ]);

            return redirect()->route('fiscal-receipts.index')
                ->with('error', 'Nu s-a putut conecta la bridge-ul fiscal. Verifică că serviciul rulează pe ' . $bridgeUrl);
        } catch (\Exception $e) {
            Log::error('Fiscal receipt exception', [
                'user_id' => Auth::id(),
                'tenant_id' => $tenant->id,
                'tenant_name' => $tenant->name,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('fiscal-receipts.index')
                ->with('error', 'Eroare neașteptată: ' . $e->getMessage());
        }
    }

    /**
     * Format duration as "Xh Ym" or "Xh" if no minutes
     */
    private function formatDuration(int $hours, int $minutes): string
    {
        if ($minutes === 0) {
            return "{$hours}h";
        }
        return "{$hours}h {$minutes}m";
    }
}

