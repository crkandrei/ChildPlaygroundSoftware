<?php

namespace App\Http\Controllers;

use App\Models\Bracelet;
use App\Models\Child;
use App\Models\Guardian;
use App\Models\PlaySession;
use App\Models\Tenant;
use App\Services\ScanService;
use App\Support\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Requests\Scan\LookupBraceletRequest;
use App\Http\Requests\Scan\AssignBraceletRequest;
use App\Http\Requests\Scan\CreateChildRequest;
use App\Http\Requests\Scan\StartSessionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScanPageController extends Controller
{
    protected ScanService $scanService;

    public function __construct(ScanService $scanService)
    {
        $this->scanService = $scanService;
    }

    /**
     * Show scan page
     */
    public function index()
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        // Get available children for the tenant
        $children = [];
        if ($tenant) {
            $children = Child::where('tenant_id', $tenant->id)
                ->with('guardian')
                ->get();
        }

        return view('scan.index', compact('children'));
    }

    /**
     * Generate new RFID code
     */
    public function generateCode(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        try {
            $code = $this->scanService->generateRandomCode($tenant);
            $scanEvent = $this->scanService->createScanEvent($tenant, $code);

            return response()->json([
                'success' => true,
                'code' => $code,
                'expires_at' => $scanEvent->expires_at->toISOString(),
                'message' => 'Cod RFID generat cu succes',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Eroare la generarea codului: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lookup bracelet by code
     */
    public function lookupBracelet(LookupBraceletRequest $request)
    {
        // Normalize code
        $code = strtoupper(trim($request->code));

        // Folosește tenant-ul utilizatorului autentificat
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        if (!$tenant) {
            return ApiResponder::error('Utilizatorul nu este asociat cu niciun tenant', 400);
        }

        return response()->json($this->scanService->lookupBracelet($code, $tenant));
    }

    /**
     * Assign bracelet to child
     */
    public function assignBracelet(AssignBraceletRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        $bracelet = Bracelet::where('code', $request->bracelet_code)
            ->where('tenant_id', $tenant->id)
            ->first();

        $child = Child::where('id', $request->child_id)
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$bracelet || !$child) {
            return ApiResponder::error('Brățară sau copil nu a fost găsit', 404);
        }

        if (!$bracelet->isAvailable()) {
            return ApiResponder::error('Brățară nu este disponibilă', 400);
        }

        // Verifică dacă copilul are deja o sesiune activă
        $existingSession = PlaySession::where('child_id', $child->id)
            ->whereNull('ended_at')
            ->first();

        if ($existingSession) {
            $childName = $child->first_name . ' ' . $child->last_name;
            return ApiResponder::error(
                "Copilul {$childName} are deja o sesiune activă care a început la " . 
                $existingSession->started_at->format('d.m.Y H:i') . 
                ". Te rog oprește sesiunea existentă înainte de a asigna o brățară nouă.",
                400
            );
        }

        try {
            $result = DB::transaction(function () use ($tenant, $child, $bracelet) {
                // Asignează brățara
                $bracelet->update([
                    'child_id' => $child->id,
                    'status' => 'assigned',
                    'assigned_at' => now(),
                ]);

                // Pornește sesiunea (dacă aruncă excepție, tranzacția se face rollback)
                $session = $this->scanService->startPlaySession($tenant, $child, $bracelet);

                return [
                    'bracelet' => $bracelet->fresh(['child.guardian']),
                    'session' => $session,
                ];
            });

            return ApiResponder::success([
                'message' => 'Brățară asignată și sesiune pornită',
                'bracelet' => $result['bracelet'],
                'session' => [
                    'id' => $result['session']->id,
                    'started_at' => $result['session']->started_at->toISOString(),
                ],
            ]);
        } catch (\Throwable $e) {
            return ApiResponder::error('Nu s-a putut asigna brățara și porni sesiunea: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Create new child and assign bracelet
     */
    public function createChild(CreateChildRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        try {
            $data = DB::transaction(function () use ($request, $tenant) {
                // Găsește brățara
                $bracelet = Bracelet::where('code', $request->bracelet_code)
                    ->where('tenant_id', $tenant->id)
                    ->lockForUpdate()
                    ->first();

                if (!$bracelet) {
                    throw new \Exception('Brățară nu a fost găsită');
                }
                if ($bracelet->child_id) {
                    throw new \Exception('Brățara este deja asignată unui copil');
                }

                // Identifică sau creează părintele/tutorul în funcție de datele primite
                if ($request->filled('guardian_id')) {
                    $guardian = Guardian::where('id', $request->guardian_id)
                        ->where('tenant_id', $tenant->id)
                        ->first();
                    if (!$guardian) {
                        throw new \Exception('Părintele selectat nu a fost găsit în acest tenant');
                    }
                } else {
                    // Verifică dacă există deja un părinte cu același telefon
                    $existingGuardian = Guardian::where('tenant_id', $tenant->id)
                        ->where('phone', $request->guardian_phone)
                        ->first();
                    
                    if ($existingGuardian) {
                        throw new \Exception(
                            "Există deja un părinte cu numărul de telefon {$request->guardian_phone}: {$existingGuardian->name}. " .
                            "Te rog selectează părinte existent în loc de creare nouă."
                        );
                    }
                    
                    $guardian = Guardian::create([
                        'name' => $request->guardian_name,
                        'phone' => $request->guardian_phone,
                        'email' => $request->guardian_email,
                        'tenant_id' => $tenant->id,
                    ]);
                }

                // Generează cod intern
                $internalCode = strtoupper(substr($request->first_name, 0, 2) . substr($request->last_name, 0, 2) . rand(100, 999));

                // Creează copilul
                $child = Child::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'birth_date' => $request->birth_date,
                    'allergies' => $request->allergies,
                    'internal_code' => $internalCode,
                    'guardian_id' => $guardian->id,
                    'tenant_id' => $tenant->id,
                ]);

                // Asignează brățara copilului
                $bracelet->update([
                    'child_id' => $child->id,
                    'status' => 'assigned',
                    'assigned_at' => now(),
                ]);

                // Pornește sesiunea; dacă eșuează, tranzacția se va anula (nu rămâne asignare fără sesiune)
                $session = $this->scanService->startPlaySession($tenant, $child, $bracelet);

                return [
                    'child' => $child,
                    'guardian' => $guardian,
                    'bracelet' => $bracelet->fresh(),
                    'session' => $session,
                ];
            });

            return ApiResponder::success([
                'message' => 'Copil creat, brățară asignată și sesiune pornită',
                'data' => [
                    'child' => $data['child'],
                    'guardian' => $data['guardian'],
                    'bracelet' => $data['bracelet'],
                    'session' => [
                        'id' => $data['session']->id,
                        'started_at' => $data['session']->started_at->toISOString(),
                    ],
                ],
            ]);

        } catch (\Throwable $e) {
            return ApiResponder::error('Nu s-a putut crea copilul și porni sesiunea: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Start a play session for a child
     */
    public function startSession(StartSessionRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        try {
            $child = Child::where('id', $request->child_id)
                ->where('tenant_id', $tenant->id)
                ->first();

            $bracelet = Bracelet::where('code', $request->bracelet_code)
                ->where('tenant_id', $tenant->id)
                ->first();

            if (!$child || !$bracelet) {
                return ApiResponder::error('Copil sau brățară nu a fost găsit', 404);
            }

            $session = $this->scanService->startPlaySession($tenant, $child, $bracelet);

            return ApiResponder::success([
                'message' => 'Sesiunea a început cu succes',
                'session' => [
                    'id' => $session->id,
                    'child_name' => $child->first_name . ' ' . $child->last_name,
                    'parent_name' => $child->guardian->name,
                    'started_at' => $session->started_at->toISOString(),
                    'bracelet_code' => $bracelet->code,
                ],
            ]);

        } catch (\Exception $e) {
            return ApiResponder::error('Eroare la începerea sesiunii: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Stop a play session
     */
    public function stopSession(Request $request, $sessionId)
    {
        try {
            // Get session first to verify bracelet
            $session = PlaySession::with('child')->findOrFail($sessionId);
            
            // Verify bracelet code if provided
            $braceletCode = $request->input('bracelet_code');
            if ($braceletCode && $session->bracelet_id) {
                $bracelet = Bracelet::find($session->bracelet_id);
                if ($bracelet && $bracelet->code !== strtoupper(trim($braceletCode))) {
                    $child = $session->child;
                    $childName = $child ? ($child->first_name . ' ' . $child->last_name) : 'necunoscut';
                    return ApiResponder::error(
                        "Brățara scanată ({$braceletCode}) nu corespunde cu sesiunea care se încearcă să fie oprită. " .
                        "Sesiunea aparține copilului {$childName} cu brățara {$bracelet->code}. " .
                        "Te rog scanează brățara corectă.",
                        400
                    );
                }
            }
            
            $session = $this->scanService->stopAndUnassign($sessionId);

            return ApiResponder::success([
                'message' => 'Sesiunea a fost oprită cu succes',
                'session' => [
                    'id' => $session->id,
                    'duration_minutes' => $session->getCurrentDurationMinutes(),
                    'duration_formatted' => $session->getFormattedDuration(),
                ],
            ]);

        } catch (\Exception $e) {
            return ApiResponder::error('Eroare la oprirea sesiunii: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Pause a play session
     */
    public function pauseSession(Request $request, $sessionId)
    {
        try {
            $session = $this->scanService->pausePlaySession((int) $sessionId);

            return ApiResponder::success([
                'message' => 'Sesiunea a fost pusă pe pauză',
                'session' => [
                    'id' => $session->id,
                    'status' => $session->status,
                    'is_paused' => $session->isPaused(),
                    'effective_seconds' => $session->getEffectiveDurationSeconds(),
                ],
            ]);
        } catch (\Exception $e) {
            return ApiResponder::error('Eroare la pauzarea sesiunii: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Resume a paused play session
     */
    public function resumeSession(Request $request, $sessionId)
    {
        try {
            $session = $this->scanService->resumePlaySession((int) $sessionId);

            return ApiResponder::success([
                'message' => 'Sesiunea a fost reluată',
                'session' => [
                    'id' => $session->id,
                    'status' => $session->status,
                    'is_paused' => $session->isPaused(),
                    'effective_seconds' => $session->getEffectiveDurationSeconds(),
                    'current_interval_started_at' => optional($session->intervals()->whereNull('ended_at')->latest('started_at')->first())->started_at?->toISOString(),
                ],
            ]);
        } catch (\Exception $e) {
            return ApiResponder::error('Eroare la reluarea sesiunii: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get active sessions
     */
    public function getActiveSessions()
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        $sessions = $this->scanService->getActiveSessions($tenant);

        return ApiResponder::success(['sessions' => $sessions]);
    }

    /**
     * Get session statistics
     */
    public function getSessionStats()
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        $stats = $this->scanService->getSessionStats($tenant);

        return ApiResponder::success(['stats' => $stats]);
    }

    /**
     * Get last 3 completed sessions for current tenant
     */
    public function recentCompletedSessions()
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        $list = $this->scanService->getRecentCompletedSessions($tenant, 3);
        return ApiResponder::success(['recent' => $list]);
    }

    /**
     * Search for children with active sessions
     */
    public function searchChildrenWithActiveSessions(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        $request->validate([
            'q' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $q = (string) $request->input('q', '');
        $limit = (int) ($request->input('limit', 15));

        // Get children with active sessions only
        $children = Child::where('tenant_id', $tenant->id)
            ->whereHas('activeSessions')
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
            ->with(['guardian:id,name,phone', 'activeSessions' => function($q) {
                $q->whereNull('ended_at')->with('intervals')->with('bracelet:id,code');
            }])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->limit($limit)
            ->get(['id','first_name','last_name','internal_code','guardian_id']);

        $results = $children->map(function ($child) {
            $activeSession = $child->activeSessions->first();
            $currentInterval = $activeSession ? $activeSession->intervals->whereStrict('ended_at', null)->sortByDesc('started_at')->first() : null;
            
            return [
                'id' => $child->id,
                'first_name' => $child->first_name,
                'last_name' => $child->last_name,
                'internal_code' => $child->internal_code,
                'guardian_name' => optional($child->guardian)->name,
                'guardian_phone' => optional($child->guardian)->phone,
                'bracelet_code' => $activeSession && $activeSession->bracelet ? $activeSession->bracelet->code : null,
                'session_id' => $activeSession ? $activeSession->id : null,
                'session_started_at' => $activeSession && $activeSession->started_at ? $activeSession->started_at->toISOString() : null,
                'session_is_paused' => $activeSession ? $activeSession->isPaused() : false,
                'session_effective_seconds' => $activeSession ? $activeSession->getEffectiveDurationSeconds() : 0,
                'session_duration_formatted' => $activeSession ? $activeSession->getFormattedDuration() : '00:00',
                'session_current_interval_started_at' => $currentInterval && $currentInterval->started_at ? $currentInterval->started_at->toISOString() : null,
            ];
        });

        return ApiResponder::success([
            'success' => true,
            'children' => $results,
        ]);
    }

    /**
     * Get active session for a specific child
     */
    public function lookupChildSession(Request $request, $childId)
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponder::error('Neautentificat', 401);
        }
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return ApiResponder::error('Nu există niciun tenant în sistem', 400);
        }

        $child = Child::where('id', $childId)
            ->where('tenant_id', $tenant->id)
            ->with(['guardian', 'bracelets'])
            ->first();

        if (!$child) {
            return ApiResponder::error('Copilul nu a fost găsit', 404);
        }

        // Get active session for this child
        $activeSession = PlaySession::where('child_id', $child->id)
            ->whereNull('ended_at')
            ->with('intervals')
            ->first();

        if (!$activeSession) {
            return ApiResponder::error('Copilul nu are o sesiune activă', 404);
        }

        $currentInterval = $activeSession->intervals->whereStrict('ended_at', null)->sortByDesc('started_at')->first();
        
        // Get bracelet for this session
        $bracelet = Bracelet::find($activeSession->bracelet_id);

        return ApiResponder::success([
            'success' => true,
            'child' => [
                'id' => $child->id,
                'first_name' => $child->first_name,
                'last_name' => $child->last_name,
                'guardian_name' => optional($child->guardian)->name,
            ],
            'bracelet' => $bracelet ? [
                'id' => $bracelet->id,
                'code' => $bracelet->code,
            ] : null,
            'active_session' => [
                'id' => $activeSession->id,
                'started_at' => optional($activeSession->started_at)->toISOString(),
                'status' => $activeSession->status ?? 'active',
                'is_paused' => $activeSession->isPaused(),
                'effective_seconds' => $activeSession->getEffectiveDurationSeconds(),
                'current_interval_started_at' => $currentInterval && $currentInterval->started_at ? $currentInterval->started_at->toISOString() : null,
            ],
        ]);
    }
}
