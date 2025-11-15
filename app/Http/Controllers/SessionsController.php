<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PlaySessionRepositoryInterface;
use App\Support\ApiResponder;
use App\Models\PlaySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct(private PlaySessionRepositoryInterface $sessions)
    {
    }
    /** Show sessions page */
    public function index()
    {
        return view('sessions.index');
    }

    /** Server-side data for sessions table */
    public function data(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->tenant) {
            return ApiResponder::error('Neautentificat sau fără tenant', 401);
        }

        $tenantId = $user->tenant->id;

        // Inputs
        $page = max(1, (int) $request->input('page', 1));
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }
        $search = trim((string) $request->input('search', ''));
        $sortBy = (string) $request->input('sort_by', 'started_at');
        $sortDir = strtolower((string) $request->input('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Allowed sorting columns map to SQL columns
        $result = $this->sessions->paginateSessions(
            $tenantId,
            $page,
            $perPage,
            $search === '' ? null : $search,
            $sortBy,
            $sortDir
        );

        return ApiResponder::success([
            'data' => $result['rows'],
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $result['total'],
                'total_pages' => (int) ceil($result['total'] / max(1, $perPage)),
                'sort_by' => $sortBy,
                'sort_dir' => $sortDir,
                'search' => $search,
            ],
        ]);
    }

    /** Show session details */
    public function show($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // SUPER_ADMIN poate vedea sesiuni din toate tenant-urile
        $query = PlaySession::where('id', $id);
        
        if (!$user->isSuperAdmin() && $user->tenant) {
            $query->where('tenant_id', $user->tenant->id);
        }

        $session = $query->with(['child.guardian', 'intervals' => function($query) {
                $query->orderBy('started_at', 'asc');
            }, 'products.product'])
            ->first();

        if (!$session) {
            abort(404, 'Sesiunea nu a fost găsită');
        }

        return view('sessions.show', compact('session'));
    }

    /** Generate receipt for session */
    public function receipt($id)
    {
        $user = Auth::user();
        if (!$user || !$user->tenant) {
            abort(401, 'Neautentificat');
        }

        $session = PlaySession::where('id', $id)
            ->where('tenant_id', $user->tenant->id)
            ->with(['child.guardian', 'tenant', 'intervals' => function($query) {
                $query->orderBy('started_at', 'asc');
            }])
            ->first();

        if (!$session) {
            abort(404, 'Sesiunea nu a fost găsită');
        }

        if (!$session->ended_at) {
            abort(400, 'Bonul poate fi generat doar pentru sesiuni finalizate');
        }

        if ($session->is_birthday) {
            abort(400, 'Nu se poate printa bon pentru sesiuni de tip Birthday');
        }

        // Ensure price is calculated
        if (!$session->calculated_price) {
            $session->saveCalculatedPrice();
            $session->refresh();
        }

        // Load products relationship if not already loaded
        if (!$session->relationLoaded('products')) {
            $session->load('products.product');
        }

        return view('sessions.receipt', compact('session'));
    }

    /**
     * Prepare fiscal receipt data for printing session
     * Returns calculated data that will be sent to bridge from client-side
     */
    public function prepareFiscalPrint($id, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Neautentificat'
            ], 401);
        }
        
        $request->validate([
            'paymentType' => 'required|in:CASH,CARD',
            'voucherHours' => 'nullable|numeric|min:0',
        ]);

        // For SUPER_ADMIN, can access any session (tenant comes from session)
        // For other roles, restrict to their tenant
        $sessionQuery = PlaySession::where('id', $id);
        
        if (!$user->isSuperAdmin() && $user->tenant) {
            $sessionQuery->where('tenant_id', $user->tenant->id);
        }
        
        $session = $sessionQuery->with(['products.product', 'tenant'])->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesiunea nu a fost găsită'
            ], 404);
        }

        if (!$session->ended_at) {
            return response()->json([
                'success' => false,
                'message' => 'Bonul poate fi generat doar pentru sesiuni finalizate'
            ], 400);
        }

        if ($session->is_birthday) {
            return response()->json([
                'success' => false,
                'message' => 'Nu se poate printa bon pentru sesiuni de tip Birthday'
            ], 400);
        }

        if ($session->isPaid()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesiunea a fost deja plătită'
            ], 400);
        }

        // Ensure price is calculated (recalculate if price is 0, as it might be incorrect)
        if (!$session->calculated_price || $session->calculated_price == 0) {
            $session->saveCalculatedPrice();
            $session->refresh();
        }

        // Get voucher hours from request
        $voucherHours = $request->input('voucherHours', 0);
        if ($voucherHours > 0) {
            $voucherHours = (float) $voucherHours;
        } else {
            $voucherHours = 0;
        }

        // Get pricing service
        $pricingService = app(\App\Services\PricingService::class);
        
        // Get effective duration in seconds and convert to hours and minutes
        $seconds = $session->getEffectiveDurationSeconds();
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        // Format duration for display (e.g., "1h 15m" or "45m")
        $duration = $this->formatDuration($hours, $minutes);

        // Calculate rounded duration (fiscalized duration)
        $durationInHours = $pricingService->getDurationInHours($session);
        $roundedHours = $pricingService->roundToHalfHour($durationInHours);
        
        // Validate voucher hours don't exceed session duration
        if ($voucherHours > $roundedHours) {
            return response()->json([
                'success' => false,
                'message' => 'Orele de voucher nu pot depăși durata sesiunii (' . $this->formatDuration(floor($roundedHours), round(($roundedHours - floor($roundedHours)) * 60)) . ')'
            ], 400);
        }

        // Get price per hour (use the one saved at calculation time, or calculate current rate)
        $pricePerHour = $session->price_per_hour_at_calculation ?? $pricingService->getHourlyRate($session->tenant, $session->started_at);
        
        // Calculate voucher price
        $voucherPrice = $voucherHours * $pricePerHour;

        // Get prices separately
        $timePrice = $session->calculated_price ?? $session->calculatePrice();
        $productsPrice = $session->getProductsTotalPrice();
        $totalPrice = $session->getTotalPrice();

        // Voucher applies ONLY to time, not to products
        // Calculate final time price after voucher discount
        $finalTimePrice = max(0, $timePrice - $voucherPrice);
        
        // Final total price = final time price + products price (products are never discounted by voucher)
        $finalPrice = $finalTimePrice + $productsPrice;
        
        // If voucher covers all time AND there are no products, no receipt needed
        // If there are products, we still need a receipt even if time is fully covered
        $noReceiptNeeded = ($finalTimePrice <= 0 && $productsPrice <= 0);

        // Calculate billed hours (total hours minus voucher hours)
        $billedHours = max(0, $roundedHours - $voucherHours);
        
        // Format rounded duration
        $roundedHoursInt = floor($roundedHours);
        $roundedMinutes = round(($roundedHours - $roundedHoursInt) * 60);
        // Handle case where roundedMinutes might be 60 (from rounding)
        if ($roundedMinutes >= 60) {
            $roundedHoursInt += 1;
            $roundedMinutes = 0;
        }
        $durationFiscalized = $this->formatDuration($roundedHoursInt, $roundedMinutes);

        // Format billed hours for display
        $billedHoursInt = floor($billedHours);
        $billedMinutes = round(($billedHours - $billedHoursInt) * 60);
        if ($billedMinutes >= 60) {
            $billedHoursInt += 1;
            $billedMinutes = 0;
        }
        $durationBilled = $this->formatDuration($billedHoursInt, $billedMinutes);

        // Calculate billed time price (only hours that will be charged)
        $billedTimePrice = $billedHours * $pricePerHour;

        // Get products data - ensure we use the actual product name
        $products = $session->products->map(function($sp) {
            // Get product name from loaded relation (should be loaded via ->with(['products.product']))
            $productName = null;
            if ($sp->product && $sp->product->name) {
                $productName = trim($sp->product->name);
            }
            
            // If name not found in relation, try loading product directly
            if (empty($productName) && $sp->product_id) {
                $product = \App\Models\Product::find($sp->product_id);
                if ($product && $product->name) {
                    $productName = trim($product->name);
                }
            }
            
            // Ensure we always have a name - use product ID as fallback if name is missing
            if (empty($productName)) {
                $productName = 'Produs ID: ' . $sp->product_id;
            }
            
            return [
                'name' => $productName,
                'quantity' => $sp->quantity,
                'unit_price' => (float) $sp->unit_price,
                'total_price' => (float) $sp->total_price,
            ];
        })->values();

        // Get tenant name
        $tenantName = $session->tenant->name ?? 'Loc de Joacă';

        // Product name
        $productName = 'Ora de joacă';

        // Build items array for bridge: time item + product items
        // Only include items if there's something to pay (finalPrice > 0)
        $items = [];
        
        if (!$noReceiptNeeded) {
            // Add time item ONLY if there's time to bill (billed hours > 0 and final time price > 0)
            // If voucher covers all time, don't include time item on receipt
            if ($billedHours > 0 && $finalTimePrice > 0) {
                $items[] = [
                    'name' => $productName . ' (' . $durationBilled . ')',
                    'quantity' => 1,
                    'price' => (float) $finalTimePrice,
                ];
            }
            
            // Add product items (products are never affected by voucher)
            foreach ($products as $product) {
                if ($product['total_price'] > 0) {
                    $items[] = [
                        'name' => $product['name'],
                        'quantity' => $product['quantity'],
                        'price' => (float) $product['unit_price'], // Use unit price, not total
                    ];
                }
            }
        }

        // Return data for client-side bridge call
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'paymentType' => $request->paymentType,
                'voucherHours' => $voucherHours,
                // Keep legacy fields for backward compatibility (not used if items is present)
                'productName' => $productName,
                'duration' => $durationBilled,
                'price' => max(0, $finalPrice),
            ],
            'receipt' => [
                'tenantName' => $tenantName,
                'timePrice' => (float) $timePrice,
                'finalTimePrice' => (float) $finalTimePrice,
                'billedTimePrice' => (float) $finalTimePrice, // Use finalTimePrice for display
                'voucherHours' => $voucherHours,
                'voucherPrice' => (float) $voucherPrice,
                'durationReal' => $duration,
                'durationFiscalized' => $durationFiscalized,
                'durationBilled' => $durationBilled,
                'products' => $products,
                'productsPrice' => (float) $productsPrice,
                'totalPrice' => (float) $totalPrice,
                'finalPrice' => max(0, $finalPrice),
                'noReceiptNeeded' => $noReceiptNeeded,
            ],
            'session' => [
                'id' => $session->id,
            ],
        ]);
    }

    /**
     * Save fiscal receipt log
     */
    public function saveFiscalReceiptLog(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Neautentificat'
            ], 401);
        }
        
        $request->validate([
            'play_session_id' => 'required|exists:play_sessions,id',
            'filename' => 'nullable|string|max:255',
            'status' => 'required|in:success,error',
            'error_message' => 'nullable|string',
            'voucher_hours' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|string|in:paid,paid_voucher',
            'payment_method' => 'nullable|string|in:CASH,CARD',
        ]);
        
        try {
            // Get tenant from play session
            $playSession = PlaySession::findOrFail($request->play_session_id);
            
            $voucherHours = $request->input('voucher_hours', null);
            if ($voucherHours !== null) {
                $voucherHours = (float) $voucherHours;
            }
            
            $log = \App\Models\FiscalReceiptLog::create([
                'type' => 'session',
                'play_session_id' => $request->play_session_id,
                'tenant_id' => $playSession->tenant_id,
                'filename' => $request->filename,
                'status' => $request->status,
                'error_message' => $request->error_message,
                'voucher_hours' => $voucherHours,
            ]);
            
            // Mark session as paid if receipt was successfully printed
            if ($request->status === 'success' && !$playSession->isPaid()) {
                $updateData = [
                    'paid_at' => now(),
                ];
                
                // Add voucher hours and payment status if provided
                if ($voucherHours !== null) {
                    $updateData['voucher_hours'] = $voucherHours;
                }
                
                $paymentStatus = $request->input('payment_status', 'paid');
                if ($paymentStatus === 'paid_voucher' || ($voucherHours !== null && $voucherHours > 0)) {
                    $updateData['payment_status'] = 'paid_voucher';
                } else {
                    $updateData['payment_status'] = 'paid';
                }
                
                // Add payment method if provided
                $paymentMethod = $request->input('payment_method');
                if ($paymentMethod && in_array($paymentMethod, ['CASH', 'CARD'])) {
                    $updateData['payment_method'] = $paymentMethod;
                }
                
                $playSession->update($updateData);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Log salvat cu succes',
                'log' => $log,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Eroare la salvarea logului: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mark session as paid with voucher (no receipt needed)
     */
    public function markPaidWithVoucher($id, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Neautentificat'
            ], 401);
        }
        
        $request->validate([
            'voucher_hours' => 'required|numeric|min:0',
        ]);

        // For SUPER_ADMIN, can access any session (tenant comes from session)
        // For other roles, restrict to their tenant
        $sessionQuery = PlaySession::where('id', $id);
        
        if (!$user->isSuperAdmin() && $user->tenant) {
            $sessionQuery->where('tenant_id', $user->tenant->id);
        }
        
        $session = $sessionQuery->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesiunea nu a fost găsită'
            ], 404);
        }

        if ($session->isPaid()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesiunea a fost deja plătită'
            ], 400);
        }

        $voucherHours = (float) $request->voucher_hours;

        // Validate voucher hours don't exceed session duration
        $pricingService = app(\App\Services\PricingService::class);
        $durationInHours = $pricingService->getDurationInHours($session);
        $roundedHours = $pricingService->roundToHalfHour($durationInHours);
        
        if ($voucherHours > $roundedHours) {
            return response()->json([
                'success' => false,
                'message' => 'Orele de voucher nu pot depăși durata sesiunii (' . $this->formatDuration(floor($roundedHours), round(($roundedHours - floor($roundedHours)) * 60)) . ')'
            ], 400);
        }

        // Mark session as paid with voucher
        $session->update([
            'paid_at' => now(),
            'voucher_hours' => $voucherHours,
            'payment_status' => 'paid_voucher',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sesiunea a fost marcată ca plătită cu voucher',
            'session' => [
                'id' => $session->id,
                'voucher_hours' => $session->voucher_hours,
                'payment_status' => $session->payment_status,
            ],
        ]);
    }

    /**
     * Update session birthday status
     */
    public function updateBirthdayStatus($id, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Neautentificat'
            ], 401);
        }

        $request->validate([
            'is_birthday' => 'required|boolean',
        ]);

        // For SUPER_ADMIN, can access any session (tenant comes from session)
        // For other roles, restrict to their tenant
        $sessionQuery = PlaySession::where('id', $id);
        
        if (!$user->isSuperAdmin() && $user->tenant) {
            $sessionQuery->where('tenant_id', $user->tenant->id);
        }
        
        $session = $sessionQuery->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesiunea nu a fost găsită'
            ], 404);
        }

        // Prevent modification if session is already paid
        if ($session->isPaid()) {
            return response()->json([
                'success' => false,
                'message' => 'Nu se poate modifica statusul Birthday pentru o sesiune deja plătită'
            ], 400);
        }

        $session->update([
            'is_birthday' => $request->is_birthday,
        ]);

        // Recalculate price if session is ended
        if ($session->ended_at) {
            $session->saveCalculatedPrice();
            $session->refresh();
        }

        return response()->json([
            'success' => true,
            'message' => $request->is_birthday ? 'Sesiunea a fost marcată ca Birthday' : 'Sesiunea nu mai este marcată ca Birthday',
            'session' => [
                'id' => $session->id,
                'is_birthday' => $session->is_birthday,
                'calculated_price' => $session->calculated_price,
                'formatted_price' => $session->getFormattedPrice(),
            ],
        ]);
    }

    /**
     * Toggle payment status for a session (Super Admin only)
     */
    public function togglePaymentStatus($id, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Neautentificat'
            ], 401);
        }

        // Only super admin can toggle payment status
        if (!$user->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Nu aveți permisiunea de a modifica statusul de plată'
            ], 403);
        }

        // Get session (super admin can access any session)
        $session = PlaySession::find($id);

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesiunea nu a fost găsită'
            ], 404);
        }

        // Toggle payment status
        if ($session->isPaid()) {
            // Mark as unpaid
            $session->update([
                'paid_at' => null,
                'payment_status' => null,
                'payment_method' => null,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Sesiunea a fost marcată ca neplătită',
                'is_paid' => false,
            ]);
        } else {
            // Mark as paid
            $session->update([
                'paid_at' => now(),
                'payment_status' => 'paid',
                'payment_method' => null, // No payment method specified when toggled manually
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Sesiunea a fost marcată ca plătită',
                'is_paid' => true,
            ]);
        }
    }

    /**
     * Format duration as "Xh Ym" or "Xh" if no minutes, or "Ym" if no hours
     */
    private function formatDuration(int $hours, int $minutes): string
    {
        if ($hours === 0 && $minutes === 0) {
            return '0m';
        }
        
        if ($hours === 0) {
            return "{$minutes}m";
        }
        
        if ($minutes === 0) {
            return "{$hours}h";
        }
        
        return "{$hours}h {$minutes}m";
    }
}


