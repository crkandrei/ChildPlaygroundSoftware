<?php

namespace App\Http\Controllers;

use App\Models\PlaySession;
use App\Models\FiscalReceiptLog;
use App\Models\PlaySessionProduct;
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
        
        // Calculate payment breakdown: cash, card, voucher
        $cashTotal = 0;
        $cardTotal = 0;
        $voucherTotal = 0;
        
        $endedSessions = $sessionsToday->whereNotNull('ended_at')->whereNotNull('calculated_price');
        
        foreach ($endedSessions as $session) {
            if ($session->isPaid()) {
                // Get total price (time + products)
                $timePrice = $session->calculated_price ?? $session->calculatePrice();
                $productsPrice = $session->getProductsTotalPrice();
                $totalPrice = $timePrice + $productsPrice;
                
                $voucherPrice = $session->getVoucherPrice();
                
                // Add voucher value
                if ($voucherPrice > 0) {
                    $voucherTotal += $voucherPrice;
                }
                
                // Amount collected = total price - voucher (voucher applies only to time)
                $amountCollected = $totalPrice - $voucherPrice;
                
                // Add cash/card amount based on payment method
                if ($session->payment_method === 'CASH') {
                    $cashTotal += $amountCollected;
                } elseif ($session->payment_method === 'CARD') {
                    $cardTotal += $amountCollected;
                } else {
                    // If no payment method specified but session is paid, assume it's cash
                    // This handles legacy data or sessions paid without fiscal receipt
                    if ($amountCollected > 0) {
                        $cashTotal += $amountCollected;
                    }
                }
            }
        }
        
        // Total money = cash + card + voucher (total value, not just collected)
        $totalMoney = $cashTotal + $cardTotal + $voucherTotal;

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
            'cashTotal' => round($cashTotal, 2),
            'cardTotal' => round($cardTotal, 2),
            'voucherTotal' => round($voucherTotal, 2),
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

        $sessionsToday = $sessionsQuery->with('products.product')->get();

        // Calculate statistics
        $totalSessions = $sessionsToday->count();
        $birthdaySessions = $sessionsToday->where('is_birthday', true)->count();
        $regularSessions = $sessionsToday->where('is_birthday', false)->count();
        
        // Calculate total billed hours and totals by category
        $totalBilledHours = 0;
        $birthdayBilledHours = 0;
        $regularBilledHours = 0;
        $birthdaySessionsTotal = 0;
        $regularSessionsTotal = 0;
        $totalVoucherHours = 0;
        
        foreach ($sessionsToday as $session) {
            if ($session->ended_at) {
                $durationInHours = $this->pricingService->getDurationInHours($session);
                $roundedHours = $this->pricingService->roundToHalfHour($durationInHours);
                
                // Add voucher hours if session was paid with voucher
                if ($session->voucher_hours && $session->voucher_hours > 0) {
                    $totalVoucherHours += $session->voucher_hours;
                }
                
                if ($session->is_birthday) {
                    $birthdayBilledHours += $roundedHours;
                    if ($session->calculated_price) {
                        $birthdaySessionsTotal += $session->calculated_price;
                    }
                } else {
                    $regularBilledHours += $roundedHours;
                    if ($session->calculated_price) {
                        $regularSessionsTotal += $session->calculated_price;
                    }
                }
                $totalBilledHours += $roundedHours;
            }
        }
        
        // Calculate total sessions value
        $totalSessionsValue = $birthdaySessionsTotal + $regularSessionsTotal;
        
        // Calculate payment breakdown: cash, card, voucher
        $cashTotal = 0;
        $cardTotal = 0;
        $voucherTotal = 0;
        
        foreach ($sessionsToday as $session) {
            if ($session->ended_at && $session->isPaid()) {
                $amountCollected = $session->getAmountCollected();
                $voucherPrice = $session->getVoucherPrice();
                
                // Add voucher value
                if ($voucherPrice > 0) {
                    $voucherTotal += $voucherPrice;
                }
                
                // Add cash/card amount based on payment method
                if ($session->payment_method === 'CASH') {
                    $cashTotal += $amountCollected;
                } elseif ($session->payment_method === 'CARD') {
                    $cardTotal += $amountCollected;
                } else {
                    // If no payment method specified but session is paid, assume it's cash/card
                    // This handles legacy data or sessions paid without fiscal receipt
                    if ($amountCollected > 0) {
                        $cashTotal += $amountCollected;
                    }
                }
            }
        }

        // Get all products sold today
        $sessionIds = $sessionsToday->pluck('id');
        $productsSold = PlaySessionProduct::whereIn('play_session_id', $sessionIds)
            ->with('product')
            ->get();

        // Group products by product_id and calculate totals
        $productsGrouped = [];
        $totalProductsValue = 0;
        foreach ($productsSold as $psp) {
            $productId = $psp->product_id;
            $productName = $psp->product ? $psp->product->name : 'Produs #' . $productId;
            $totalPrice = $psp->total_price;

            if (!isset($productsGrouped[$productId])) {
                $productsGrouped[$productId] = [
                    'name' => $productName,
                    'total' => 0,
                    'quantity' => 0,
                ];
            }
            $productsGrouped[$productId]['total'] += $totalPrice;
            $productsGrouped[$productId]['quantity'] += $psp->quantity;
            $totalProductsValue += $totalPrice;
        }

        // Format hours for display
        $formatHours = function($hours) {
            $hoursInt = floor($hours);
            $minutesInt = round(($hours - $hoursInt) * 60);
            if ($minutesInt >= 60) {
                $hoursInt += 1;
                $minutesInt = 0;
            }
            $formatted = $hoursInt . 'h';
            if ($minutesInt > 0) {
                $formatted .= ' ' . $minutesInt . 'm';
            }
            return $formatted;
        };

        return view('end-of-day.print-non-fiscal', [
            'totalSessions' => $totalSessions,
            'birthdaySessions' => $birthdaySessions,
            'regularSessions' => $regularSessions,
            'birthdaySessionsTotal' => $birthdaySessionsTotal,
            'regularSessionsTotal' => $regularSessionsTotal,
            'totalSessionsValue' => $totalSessionsValue,
            'totalBilledHours' => $formatHours($totalBilledHours),
            'birthdayBilledHours' => $formatHours($birthdayBilledHours),
            'totalVoucherHours' => $formatHours($totalVoucherHours),
            'productsGrouped' => $productsGrouped,
            'totalProductsValue' => $totalProductsValue,
            'cashTotal' => round($cashTotal, 2),
            'cardTotal' => round($cardTotal, 2),
            'voucherTotal' => round($voucherTotal, 2),
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
            // Send request to bridge (increase timeout to 90 seconds for Z report)
            // Bridge waits up to 60 seconds for ECR response, so we need more time
            $bridgeUrl = config('services.fiscal_bridge.url', 'http://localhost:9000');
            $response = Http::timeout(90)->post($bridgeUrl . '/z-report');

            if (!$response->successful()) {
                // Save error log for connection failure
                // Get tenant_id from user if available (works for both super admin and regular users)
                $tenantId = $user->tenant_id ?? null;
                
                try {
                    FiscalReceiptLog::create([
                        'type' => 'z_report',
                        'play_session_id' => null,
                        'tenant_id' => $tenantId,
                        'filename' => null,
                        'status' => 'error',
                        'error_message' => 'Nu s-a putut conecta la bridge-ul fiscal (HTTP ' . $response->status() . ')',
                    ]);
                } catch (\Exception $logError) {
                    \Log::error('Failed to save Z report error log', ['error' => $logError->getMessage()]);
                }
                
                throw new \Exception('Nu s-a putut conecta la bridge-ul fiscal');
            }

            $bridgeData = $response->json();

            if (!$bridgeData || ($bridgeData['status'] ?? '') !== 'success') {
                // Save error log
                // Get tenant_id from user if available (works for both super admin and regular users)
                $tenantId = $user->tenant_id ?? null;
                
                try {
                    FiscalReceiptLog::create([
                        'type' => 'z_report',
                        'play_session_id' => null,
                        'tenant_id' => $tenantId,
                        'filename' => $bridgeData['file'] ?? null,
                        'status' => 'error',
                        'error_message' => $bridgeData['message'] ?? $bridgeData['details'] ?? 'Eroare de la bridge-ul fiscal',
                    ]);
                } catch (\Exception $logError) {
                    \Log::error('Failed to save Z report error log', ['error' => $logError->getMessage()]);
                }
                
                throw new \Exception($bridgeData['message'] ?? $bridgeData['details'] ?? 'Eroare de la bridge-ul fiscal');
            }

            // Save success log
            // Get tenant_id from user if available (works for both super admin and regular users)
            $tenantId = $user->tenant_id ?? null;
            
            try {
                FiscalReceiptLog::create([
                    'type' => 'z_report',
                    'play_session_id' => null,
                    'tenant_id' => $tenantId,
                    'filename' => $bridgeData['file'] ?? null,
                    'status' => 'success',
                    'error_message' => null,
                ]);
            } catch (\Exception $logError) {
                \Log::error('Failed to save Z report success log', [
                    'error' => $logError->getMessage(),
                    'bridge_data' => $bridgeData
                ]);
                // Don't fail the request if log saving fails
            }

            return response()->json([
                'success' => true,
                'message' => 'Raportul Z a fost generat cu succes',
                'file' => $bridgeData['file'] ?? null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Z report generation failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? null
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Eroare la generarea raportului Z: ' . $e->getMessage(),
            ], 500);
        }
    }
}

