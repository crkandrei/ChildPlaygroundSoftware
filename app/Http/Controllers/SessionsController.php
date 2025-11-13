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
        if (!$user || !$user->tenant) {
            return redirect()->route('login');
        }

        $session = PlaySession::where('id', $id)
            ->where('tenant_id', $user->tenant->id)
            ->with(['child.guardian', 'intervals' => function($query) {
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
        
        // Ensure role relationship is loaded
        if (!isset($user->role)) {
            $user->load('role');
        }
        
        // Check if user is SUPER_ADMIN
        if (!$user->role || $user->role->name !== 'SUPER_ADMIN') {
            return response()->json([
                'success' => false,
                'message' => 'Acces permis doar pentru super admin'
            ], 403);
        }
        
        $request->validate([
            'paymentType' => 'required|in:CASH,CARD',
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

        // Ensure price is calculated (recalculate if price is 0, as it might be incorrect)
        if (!$session->calculated_price || $session->calculated_price == 0) {
            $session->saveCalculatedPrice();
            $session->refresh();
        }

        // Get effective duration in seconds and convert to hours and minutes
        $seconds = $session->getEffectiveDurationSeconds();
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        // Format duration for display (e.g., "1h 15m" or "45m")
        $duration = $this->formatDuration($hours, $minutes);

        // Calculate rounded duration (fiscalized duration)
        $pricingService = app(\App\Services\PricingService::class);
        $durationInHours = $pricingService->getDurationInHours($session);
        $roundedHours = $pricingService->roundToHalfHour($durationInHours);
        
        // Format rounded duration
        $roundedHoursInt = floor($roundedHours);
        $roundedMinutes = round(($roundedHours - $roundedHoursInt) * 60);
        // Handle case where roundedMinutes might be 60 (from rounding)
        if ($roundedMinutes >= 60) {
            $roundedHoursInt += 1;
            $roundedMinutes = 0;
        }
        $durationFiscalized = $this->formatDuration($roundedHoursInt, $roundedMinutes);

        // Get prices separately
        $timePrice = $session->calculated_price ?? $session->calculatePrice();
        $productsPrice = $session->getProductsTotalPrice();
        $totalPrice = $session->getTotalPrice();

        // Get products data
        $products = $session->products->map(function($sp) {
            return [
                'name' => $sp->product->name ?? 'Produs',
                'quantity' => $sp->quantity,
                'unit_price' => (float) $sp->unit_price,
                'total_price' => (float) $sp->total_price,
            ];
        })->values();

        // Get tenant name
        $tenantName = $session->tenant->name ?? 'Loc de Joacă';

        // Product name
        $productName = 'Ora de joacă';

        // Return data for client-side bridge call
        return response()->json([
            'success' => true,
            'data' => [
                'productName' => $productName,
                'duration' => $duration,
                'price' => $totalPrice,
                'paymentType' => $request->paymentType,
            ],
            'receipt' => [
                'tenantName' => $tenantName,
                'timePrice' => (float) $timePrice,
                'durationReal' => $duration,
                'durationFiscalized' => $durationFiscalized,
                'products' => $products,
                'productsPrice' => (float) $productsPrice,
                'totalPrice' => (float) $totalPrice,
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
        
        // Ensure role relationship is loaded
        if (!isset($user->role)) {
            $user->load('role');
        }
        
        // Check if user is SUPER_ADMIN
        if (!$user->role || $user->role->name !== 'SUPER_ADMIN') {
            return response()->json([
                'success' => false,
                'message' => 'Acces permis doar pentru super admin'
            ], 403);
        }
        
        $request->validate([
            'play_session_id' => 'required|exists:play_sessions,id',
            'filename' => 'nullable|string|max:255',
            'status' => 'required|in:success,error',
            'error_message' => 'nullable|string',
        ]);
        
        try {
            $log = \App\Models\FiscalReceiptLog::create([
                'play_session_id' => $request->play_session_id,
                'filename' => $request->filename,
                'status' => $request->status,
                'error_message' => $request->error_message,
            ]);
            
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


