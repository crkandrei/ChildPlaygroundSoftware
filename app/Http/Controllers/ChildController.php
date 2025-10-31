<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Guardian;
use App\Models\Bracelet;
use App\Models\PlaySession;
use App\Support\ApiResponder;
use App\Support\ActionLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChildController extends Controller
{
    /**
     * Display a listing of children with their active sessions
     */
    public function index()
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        // Get children with their guardians and active sessions
        $children = Child::where('tenant_id', $tenant->id)
            ->with(['guardian', 'bracelets' => function($query) {
                $query->where('status', 'assigned');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get active sessions (placeholder - will be implemented with proper session management)
        $activeSessions = collect(); // This will be replaced with actual session data

        return view('children.index', compact('children', 'activeSessions'));
    }

    /**
     * Show the form for creating a new child
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        // Get guardians for the tenant
        $guardians = Guardian::where('tenant_id', $tenant->id)
            ->orderBy('name')
            ->get();

        // Pre-select guardian if provided via query parameter
        $preselectedGuardianId = $request->query('guardian_id');
        
        // Validate that the guardian exists and belongs to this tenant
        if ($preselectedGuardianId) {
            $guardianExists = $guardians->contains('id', $preselectedGuardianId);
            if (!$guardianExists) {
                $preselectedGuardianId = null;
            }
        }

        return view('children.create', compact('guardians', 'preselectedGuardianId'));
    }

    /**
     * Store a newly created child
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        $minDate = now()->subYears(18)->format('Y-m-d');
        
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'birth_date' => ["required", "date", "before:today", "after_or_equal:{$minDate}"],
            'guardian_id' => 'required|exists:guardians,id',
            'notes' => 'nullable|string|max:1000',
        ], [
            'birth_date.before' => 'Data nașterii nu poate fi în viitor sau astăzi.',
            'birth_date.after_or_equal' => 'Data nașterii indică un copil mai mare de 18 ani. Copilul trebuie să aibă maximum 18 ani.',
        ]);

        // Check if guardian belongs to the same tenant
        $guardian = Guardian::where('id', $request->guardian_id)
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$guardian) {
            return redirect()->back()->with('error', 'Părintele selectat nu există');
        }

        // Generate internal code
        $internalCode = $this->generateInternalCode($tenant);

        $child = Child::create([
            'tenant_id' => $tenant->id,
            'guardian_id' => $request->guardian_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'internal_code' => $internalCode,
            'notes' => $request->notes,
        ]);

        ActionLogger::logCrud('created', 'Child', $child->id, [
            'name' => $child->first_name . ' ' . $child->last_name,
            'internal_code' => $internalCode,
        ]);

        return redirect()->route('children.index')->with('success', 'Copilul a fost adăugat cu succes');
    }

    /**
     * Display the specified child
     */
    public function show(Child $child)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $child->tenant_id !== $tenant->id) {
            return redirect()->route('children.index')->with('error', 'Copilul nu a fost găsit');
        }

        // Load guardian, bracelets, and recent scan events
        $child->load([
            'guardian',
            'bracelets' => function($query) {
                $query->with(['scanEvents' => function($q) {
                    $q->orderBy('scanned_at', 'desc')->limit(10);
                }]);
            }
        ]);

        // Load play sessions with intervals and bracelet, ordered by newest first
        $playSessions = PlaySession::where('child_id', $child->id)
            ->with(['bracelet', 'intervals'])
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

        return view('children.show', compact('child', 'playSessions', 'totalPrice'));
    }

    /**
     * Show the form for editing the specified child
     */
    public function edit(Child $child)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $child->tenant_id !== $tenant->id) {
            return redirect()->route('children.index')->with('error', 'Copilul nu a fost găsit');
        }

        $guardians = Guardian::where('tenant_id', $tenant->id)
            ->orderBy('name')
            ->get();

        return view('children.edit', compact('child', 'guardians'));
    }

    /**
     * Update the specified child
     */
    public function update(Request $request, Child $child)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $child->tenant_id !== $tenant->id) {
            return redirect()->route('children.index')->with('error', 'Copilul nu a fost găsit');
        }

        $minDate = now()->subYears(18)->format('Y-m-d');
        
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'birth_date' => ["required", "date", "before:today", "after_or_equal:{$minDate}"],
            'guardian_id' => 'required|exists:guardians,id',
            'notes' => 'nullable|string|max:1000',
        ], [
            'birth_date.before' => 'Data nașterii nu poate fi în viitor sau astăzi.',
            'birth_date.after_or_equal' => 'Data nașterii indică un copil mai mare de 18 ani. Copilul trebuie să aibă maximum 18 ani.',
        ]);

        // Check if guardian belongs to the same tenant
        $guardian = Guardian::where('id', $request->guardian_id)
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$guardian) {
            return redirect()->back()->with('error', 'Părintele selectat nu există');
        }

        $dataBefore = [
            'first_name' => $child->first_name,
            'last_name' => $child->last_name,
            'birth_date' => $child->birth_date?->toDateString(),
            'guardian_id' => $child->guardian_id,
            'notes' => $child->notes,
        ];

        $child->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'guardian_id' => $request->guardian_id,
            'notes' => $request->notes,
        ]);

        $dataAfter = [
            'first_name' => $child->first_name,
            'last_name' => $child->last_name,
            'birth_date' => $child->birth_date?->toDateString(),
            'guardian_id' => $child->guardian_id,
            'notes' => $child->notes,
        ];

        ActionLogger::logAudit('updated', 'Child', $child->id, $dataBefore, $dataAfter);

        return redirect()->route('children.index')->with('success', 'Copilul a fost actualizat cu succes');
    }

    /**
     * Remove the specified child
     */
    public function destroy(Child $child)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $child->tenant_id !== $tenant->id) {
            return redirect()->route('children.index')->with('error', 'Copilul nu a fost găsit');
        }

        // Check if child has active sessions
        $hasActiveSessions = $child->bracelets()
            ->where('status', 'assigned')
            ->exists();

        if ($hasActiveSessions) {
            return redirect()->route('children.index')->with('error', 'Nu se poate șterge copilul - are sesiuni active');
        }

        $childData = [
            'first_name' => $child->first_name,
            'last_name' => $child->last_name,
            'internal_code' => $child->internal_code,
        ];

        $child->delete();

        ActionLogger::logCrud('deleted', 'Child', $child->id, $childData);

        return redirect()->route('children.index')->with('success', 'Copilul a fost șters cu succes');
    }

    /**
     * Generate unique internal code for tenant
     */
    private function generateInternalCode($tenant)
    {
        do {
            $code = 'CH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Child::where('tenant_id', $tenant->id)
            ->where('internal_code', $code)
            ->exists());

        return $code;
    }

    /**
     * Server-side search for children (AJAX)
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
            'guardian_id' => 'nullable|integer',
            'exclude_active_sessions' => 'nullable|boolean',
        ]);

        $q = (string) $request->input('q', '');
        $limit = (int) ($request->input('limit', 15));
        $guardianId = $request->input('guardian_id');
        $excludeActiveSessions = $request->boolean('exclude_active_sessions', false);

        $children = Child::where('tenant_id', $tenant->id)
            ->when($excludeActiveSessions, function ($query) {
                // Exclude children with active sessions
                $query->whereDoesntHave('playSessions', function ($q) {
                    $q->whereNull('ended_at');
                });
            })
            ->when(!empty($guardianId), function ($query) use ($guardianId) {
                $query->where('guardian_id', (int) $guardianId);
            })
            ->when($q !== '', function ($query) use ($q) {
                $like = "%" . str_replace(['%','_'], ['\\%','\\_'], $q) . "%";
                $query->where(function ($inner) use ($like) {
                    $inner->where('first_name', 'LIKE', $like)
                          ->orWhere('last_name', 'LIKE', $like)
                          ->orWhere('internal_code', 'LIKE', $like)
                          ->orWhereHas('guardian', function ($g) use ($like) {
                              $g->where('name', 'LIKE', $like)
                                ->orWhere('phone', 'LIKE', $like);
                          });
                });
            })
            ->with(['guardian:id,name,phone'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->limit($limit)
            ->get(['id','first_name','last_name','internal_code','guardian_id']);

        $results = $children->map(function ($c) {
            return [
                'id' => $c->id,
                'first_name' => $c->first_name,
                'last_name' => $c->last_name,
                'internal_code' => $c->internal_code,
                'guardian_name' => optional($c->guardian)->name,
                'guardian_phone' => optional($c->guardian)->phone,
            ];
        });

        return response()->json([
            'success' => true,
            'children' => $results,
        ]);
    }

    /**
     * Server-side data for children table (pagination/search/sort)
     */
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
        $sortBy = (string) $request->input('sort_by', 'session');
        $sortDir = strtolower((string) $request->input('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Base query
        $query = Child::where('tenant_id', $tenantId)
            ->with(['guardian:id,name,phone', 'bracelets:id,child_id,code,status'])
            ->with(['activeSessions' => function($q) {
                $q->whereNull('ended_at')->with('intervals');
            }])
            // Attach active session id and start time (if any)
            ->addSelect([
                'active_session_id' => PlaySession::select('id')
                    ->whereColumn('child_id', 'children.id')
                    ->whereNull('ended_at')
                    ->latest('started_at')
                    ->limit(1),
            ])
            ->addSelect([
                'active_started_at' => PlaySession::select('started_at')
                    ->whereColumn('child_id', 'children.id')
                    ->whereNull('ended_at')
                    ->latest('started_at')
                    ->limit(1),
            ])
            ->when($search !== '', function ($q) use ($search) {
                $like = "%" . str_replace(['%','_'], ['\\%','\\_'], $search) . "%";
                $q->where(function ($inner) use ($like) {
                    $inner->where('first_name', 'LIKE', $like)
                          ->orWhere('last_name', 'LIKE', $like)
                          ->orWhere('internal_code', 'LIKE', $like)
                          ->orWhereHas('guardian', function ($g) use ($like) {
                              $g->where('name', 'LIKE', $like)
                                ->orWhere('phone', 'LIKE', $like);
                          })
                          ->orWhereHas('bracelets', function ($b) use ($like) {
                              $b->where('code', 'LIKE', $like);
                          });
                });
            });

        // Sort map
        switch ($sortBy) {
            case 'session':
                // Active sessions first, ordered by oldest active_started_at first
                $query->orderByRaw('CASE WHEN active_session_id IS NULL THEN 1 ELSE 0 END ASC')
                      ->orderBy('active_started_at', 'asc')
                      ->orderBy('created_at', 'desc');
                break;
            case 'child_name':
                $query->orderBy('first_name', $sortDir)->orderBy('last_name', $sortDir);
                break;
            case 'guardian_name':
                $query->join('guardians', 'children.guardian_id', '=', 'guardians.id')
                      ->select('children.*')
                      ->orderBy('guardians.name', $sortDir);
                break;
            case 'guardian_phone':
                $query->join('guardians', 'children.guardian_id', '=', 'guardians.id')
                      ->select('children.*')
                      ->orderBy('guardians.phone', $sortDir);
                break;
            case 'internal_code':
                $query->orderBy('internal_code', $sortDir);
                break;
            case 'birth_date':
                $query->orderBy('birth_date', $sortDir);
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', $sortDir);
                break;
        }

        $total = (clone $query)->count('children.id');
        $rows = $query->skip(($page - 1) * $perPage)
                      ->take($perPage)
                      ->get();

        $dataRows = $rows->map(function ($c) {
            $braceletCodes = $c->bracelets->pluck('code')->values();
            $firstStatus = optional($c->bracelets->first())->status;
            $activeStartedAt = $c->active_started_at ? Carbon::parse($c->active_started_at)->toISOString() : null;
            
            // Get effective duration (excluding pauses) for active session
            // Use ONLY closed intervals for live timer (frontend will add current interval)
            $effectiveSeconds = null;
            $isPaused = false;
            $currentIntervalStartedAt = null;
            if ($c->activeSessions && $c->activeSessions->isNotEmpty()) {
                $session = $c->activeSessions->first();
                $effectiveSeconds = $session->getClosedIntervalsDurationSeconds();
                $isPaused = $session->isPaused();
                // Get current active interval start time
                if (!$isPaused) {
                    $openInterval = $session->intervals()->whereNull('ended_at')->latest('started_at')->first();
                    $currentIntervalStartedAt = $openInterval && $openInterval->started_at 
                        ? $openInterval->started_at->toISOString() 
                        : null;
                }
            }
            
            return [
                'id' => $c->id,
                'first_name' => $c->first_name,
                'last_name' => $c->last_name,
                'child_name' => trim(($c->first_name ?? '') . ' ' . ($c->last_name ?? '')),
                'guardian_name' => optional($c->guardian)->name,
                'guardian_phone' => optional($c->guardian)->phone,
                'internal_code' => $c->internal_code,
                'birth_date' => optional($c->birth_date)->format('Y-m-d'),
                'bracelet_codes' => $braceletCodes,
                'bracelet_status' => $firstStatus,
                'active_session_id' => $c->active_session_id,
                'active_started_at' => $activeStartedAt,
                'effective_seconds' => $effectiveSeconds,
                'is_paused' => $isPaused,
                'current_interval_started_at' => $currentIntervalStartedAt,
            ];
        });

        return ApiResponder::success([
            'data' => $dataRows,
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => (int) ceil($total / max(1, $perPage)),
                'sort_by' => $sortBy,
                'sort_dir' => $sortDir,
                'search' => $search,
            ],
        ]);
    }
}
