<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Child;
use App\Models\PlaySession;
use App\Support\ActionLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{
    /**
     * Display a listing of guardians
     */
    public function index()
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        // Stats for cards - only counts
        $totalGuardians = Guardian::where('tenant_id', $tenant->id)->count();
        $guardiansWithChildren = Guardian::where('tenant_id', $tenant->id)
            ->has('children')
            ->count();
        $guardiansWithoutChildren = $totalGuardians - $guardiansWithChildren;

        return view('guardians.index', [
            'totalGuardians' => $totalGuardians,
            'guardiansWithChildren' => $guardiansWithChildren,
            'guardiansWithoutChildren' => $guardiansWithoutChildren,
        ]);
    }

    /**
     * Show the form for creating a new guardian
     */
    public function create()
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        return view('guardians.create');
    }

    /**
     * Store a newly created guardian
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $guardian = Guardian::create([
            'tenant_id' => $tenant->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'notes' => $request->notes,
        ]);

        ActionLogger::logCrud('created', 'Guardian', $guardian->id, [
            'name' => $guardian->name,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'guardian' => $guardian,
                'message' => 'Părintele a fost adăugat cu succes',
            ]);
        }

        return redirect()->route('guardians.index')->with('success', 'Părintele a fost adăugat cu succes');
    }

    /**
     * Display the specified guardian
     */
    public function show(Guardian $guardian)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $guardian->tenant_id !== $tenant->id) {
            return redirect()->route('guardians.index')->with('error', 'Părintele nu a fost găsit');
        }

        // Load children with their bracelets
        $guardian->load(['children' => function($query) {
            $query->orderBy('created_at', 'desc')->with('bracelets');
        }]);

        // Load play sessions for all children of this guardian
        $childIds = $guardian->children->pluck('id');
        $playSessions = PlaySession::whereIn('child_id', $childIds)
            ->with(['child', 'bracelet', 'intervals'])
            ->orderBy('started_at', 'desc')
            ->get()
            ->map(function ($session) {
                $isActive = is_null($session->ended_at);
                
                if ($isActive) {
                    // Active session: use closed intervals only
                    $effectiveSeconds = $session->getClosedIntervalsDurationSeconds();
                    $isPaused = $session->isPaused();
                    $currentIntervalStartedAt = null;
                    
                    if (!$isPaused) {
                        $openInterval = $session->intervals()->whereNull('ended_at')->latest('started_at')->first();
                        $currentIntervalStartedAt = $openInterval && $openInterval->started_at 
                            ? $openInterval->started_at->toISOString() 
                            : null;
                    }
                    
                    // Calculate estimated price for active session
                    $price = $session->calculatePrice();
                    
                    return [
                        'id' => $session->id,
                        'child_id' => $session->child_id,
                        'child_name' => $session->child ? trim(($session->child->first_name ?? '') . ' ' . ($session->child->last_name ?? '')) : '-',
                        'started_at' => $session->started_at,
                        'ended_at' => null,
                        'status' => $session->status,
                        'bracelet_code' => $session->bracelet->code ?? null,
                        'effective_seconds' => $effectiveSeconds,
                        'is_paused' => $isPaused,
                        'current_interval_started_at' => $currentIntervalStartedAt,
                        'is_active' => true,
                        'price' => $price,
                        'formatted_price' => $session->getFormattedPrice(),
                    ];
                } else {
                    // Closed session: use all intervals
                    $effectiveSeconds = $session->getEffectiveDurationSeconds();
                    
                    // Use calculated price if available, otherwise calculate
                    $price = $session->calculated_price ?? $session->calculatePrice();
                    
                    return [
                        'id' => $session->id,
                        'child_id' => $session->child_id,
                        'child_name' => $session->child ? trim(($session->child->first_name ?? '') . ' ' . ($session->child->last_name ?? '')) : '-',
                        'started_at' => $session->started_at,
                        'ended_at' => $session->ended_at,
                        'status' => $session->status,
                        'bracelet_code' => $session->bracelet->code ?? null,
                        'effective_seconds' => $effectiveSeconds,
                        'is_paused' => false,
                        'current_interval_started_at' => null,
                        'is_active' => false,
                        'price' => $price,
                        'formatted_price' => $session->getFormattedPrice(),
                    ];
                }
            });

        // Calculate total price
        $totalPrice = $playSessions->sum('price');

        return view('guardians.show', compact('guardian', 'playSessions', 'totalPrice'));
    }

    /**
     * Show the form for editing the specified guardian
     */
    public function edit(Guardian $guardian)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $guardian->tenant_id !== $tenant->id) {
            return redirect()->route('guardians.index')->with('error', 'Părintele nu a fost găsit');
        }

        return view('guardians.edit', compact('guardian'));
    }

    /**
     * Update the specified guardian
     */
    public function update(Request $request, Guardian $guardian)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $guardian->tenant_id !== $tenant->id) {
            return redirect()->route('guardians.index')->with('error', 'Părintele nu a fost găsit');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $dataBefore = [
            'name' => $guardian->name,
            'phone' => $guardian->phone,
            'email' => $guardian->email,
            'notes' => $guardian->notes,
        ];

        $guardian->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'notes' => $request->notes,
        ]);

        $dataAfter = [
            'name' => $guardian->name,
            'phone' => $guardian->phone,
            'email' => $guardian->email,
            'notes' => $guardian->notes,
        ];

        ActionLogger::logAudit('updated', 'Guardian', $guardian->id, $dataBefore, $dataAfter);

        return redirect()->route('guardians.index')->with('success', 'Părintele a fost actualizat cu succes');
    }

    /**
     * Remove the specified guardian
     */
    public function destroy(Guardian $guardian)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $guardian->tenant_id !== $tenant->id) {
            return redirect()->route('guardians.index')->with('error', 'Părintele nu a fost găsit');
        }

        // Check if guardian has children
        if ($guardian->children()->count() > 0) {
            return redirect()->route('guardians.index')->with('error', 'Nu se poate șterge părintele - are copii înregistrați');
        }

        $guardianData = [
            'name' => $guardian->name,
        ];

        $guardian->delete();

        ActionLogger::logCrud('deleted', 'Guardian', $guardian->id, $guardianData);

        return redirect()->route('guardians.index')->with('success', 'Părintele a fost șters cu succes');
    }

    /**
     * Server-side search for guardians (AJAX)
     */
    public function search(Request $request)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        if (!$tenant) {
            return response()->json(['success' => false, 'message' => 'Tenant lipsă'], 400);
        }

        $request->validate([
            'q' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $q = (string) $request->input('q', '');
        $limit = (int) ($request->input('limit', 20));

        $results = Guardian::where('tenant_id', $tenant->id)
            ->when($q !== '', function ($query) use ($q) {
                $like = "%" . str_replace(['%','_'], ['\\%','\\_'], $q) . "%";
                $query->where(function ($inner) use ($like) {
                    $inner->where('name', 'LIKE', $like)
                          ->orWhere('phone', 'LIKE', $like)
                          ->orWhere('email', 'LIKE', $like);
                });
            })
            ->orderBy('name')
            ->limit($limit)
            ->get(['id','name','phone','email']);

        return response()->json([
            'success' => true,
            'guardians' => $results,
        ]);
    }

    /**
     * Server-side data for guardians table (pagination/search/sort)
     */
    public function data(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->tenant) {
            return response()->json([
                'success' => false,
                'message' => 'Neautentificat sau fără tenant'
            ], 401);
        }

        $tenantId = $user->tenant->id;

        // Inputs
        $page = max(1, (int) $request->input('page', 1));
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }
        $search = trim((string) $request->input('search', ''));
        $sortBy = (string) $request->input('sort_by', 'name');
        $sortDir = strtolower((string) $request->input('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        // Base query
        $query = Guardian::where('tenant_id', $tenantId)
            ->withCount('children')
            ->when($search !== '', function ($q) use ($search) {
                $like = "%" . str_replace(['%','_'], ['\\%','\\_'], $search) . "%";
                $q->where(function ($inner) use ($like) {
                    $inner->where('name', 'LIKE', $like)
                          ->orWhere('phone', 'LIKE', $like)
                          ->orWhere('email', 'LIKE', $like)
                          ->orWhere('notes', 'LIKE', $like);
                });
            });

        // Sort
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortDir);
                break;
            case 'phone':
                $query->orderBy('phone', $sortDir);
                break;
            case 'email':
                $query->orderBy('email', $sortDir);
                break;
            case 'children_count':
                $query->orderBy('children_count', $sortDir);
                break;
            case 'created_at':
                $query->orderBy('created_at', $sortDir);
                break;
            default:
                $query->orderBy('name', $sortDir);
                break;
        }

        $total = $query->count();
        $rows = $query->skip(($page - 1) * $perPage)
                      ->take($perPage)
                      ->get();

        $dataRows = $rows->map(function ($g) {
            return [
                'id' => $g->id,
                'name' => $g->name,
                'phone' => $g->phone,
                'email' => $g->email,
                'notes' => $g->notes,
                'children_count' => $g->children_count,
                'created_at' => $g->created_at->format('d.m.Y'),
            ];
        });

        $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;

        return response()->json([
            'success' => true,
            'data' => $dataRows,
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => $totalPages,
            ],
        ]);
    }
}
