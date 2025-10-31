<?php

namespace App\Services;

use App\Models\ScanEvent;
use App\Models\PlaySession;
use App\Models\Bracelet;
use App\Repositories\Contracts\BraceletRepositoryInterface;
use App\Models\Child;
use App\Models\Tenant;
use App\Support\ActionLogger;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ScanService
{
    public function __construct(private ?BraceletRepositoryInterface $bracelets = null)
    {
        // allow existing usages; repository is optional DI
    }
    /**
     * Charset pentru generarea codurilor (fără O/0, I/1)
     */
    private const CHARSET = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    
    /**
     * Lungimea codului (configurabilă)
     */
    private const CODE_LENGTH = 10;
    
    /**
     * TTL pentru coduri în secunde (configurabil)
     */
    private const CODE_TTL_SECONDS = 60;

    /**
     * Generează un cod random unic pentru un tenant
     */
    public function generateRandomCode(Tenant $tenant): string
    {
        $maxAttempts = 10;
        $attempts = 0;

        do {
            $code = $this->generateCode();
            $attempts++;
            
            // Verifică dacă codul este unic în intervalul TTL
            $isUnique = !$this->codeExistsInTTL($code, $tenant);
            
            if ($isUnique) {
                break;
            }
            
            if ($attempts >= $maxAttempts) {
                throw new \Exception('Nu s-a putut genera un cod unic după ' . $maxAttempts . ' încercări');
            }
            
        } while (!$isUnique);

        return $code;
    }

    /**
     * Creează un eveniment de scanare
     */
    public function createScanEvent(Tenant $tenant, string $code): ScanEvent
    {
        $now = now();
        $expiresAt = $now->copy()->addSeconds(self::CODE_TTL_SECONDS);

        $scanEvent = ScanEvent::create([
            'tenant_id' => $tenant->id,
            'code_used' => $code,
            'status' => 'pending',
            'scanned_at' => $now,
            'expires_at' => $expiresAt,
        ]);

        ActionLogger::logScan('created', $code, [
            'scan_event_id' => $scanEvent->id,
            'expires_at' => $expiresAt->toIso8601String(),
        ]);

        return $scanEvent;
    }

    /**
     * Validează un cod de scanare
     */
    public function validateCode(string $code, Tenant $tenant): array
    {
        $scanEvent = ScanEvent::where('code_used', $code)
            ->where('tenant_id', $tenant->id)
            ->where('expires_at', '>', now())
            ->first();

        if (!$scanEvent) {
            return [
                'valid' => false,
                'message' => 'Cod invalid sau expirat',
                'scan_event' => null,
            ];
        }

        if ($scanEvent->isExpired()) {
            $scanEvent->update(['status' => 'expired']);
            ActionLogger::logScan('expired', $code, [
                'scan_event_id' => $scanEvent->id,
            ]);
            return [
                'valid' => false,
                'message' => 'Cod expirat',
                'scan_event' => $scanEvent,
            ];
        }

        // Marchează codul ca valid
        $scanEvent->update(['status' => 'valid']);
        ActionLogger::logScan('validated', $code, [
            'scan_event_id' => $scanEvent->id,
        ]);

        return [
            'valid' => true,
            'message' => 'Cod valid',
            'scan_event' => $scanEvent,
        ];
    }

    /**
     * Generează un cod random
     */
    private function generateCode(): string
    {
        $code = '';
        $charsetLength = strlen(self::CHARSET);
        
        for ($i = 0; $i < self::CODE_LENGTH; $i++) {
            $code .= self::CHARSET[random_int(0, $charsetLength - 1)];
        }
        
        return $code;
    }

    /**
     * Verifică dacă codul există în intervalul TTL
     */
    private function codeExistsInTTL(string $code, Tenant $tenant): bool
    {
        $ttlStart = now()->subSeconds(self::CODE_TTL_SECONDS);
        
        return ScanEvent::where('code_used', $code)
            ->where('tenant_id', $tenant->id)
            ->where('created_at', '>=', $ttlStart)
            ->exists();
    }

    /**
     * Curăță codurile expirate
     */
    public function cleanupExpiredCodes(): int
    {
        return ScanEvent::where('expires_at', '<', now())
            ->where('status', 'pending')
            ->update(['status' => 'expired']);
    }

    /**
     * Obține statistici pentru un tenant
     */
    public function getTenantStats(Tenant $tenant, int $days = 7): array
    {
        $startDate = now()->subDays($days);
        
        $totalScans = ScanEvent::where('tenant_id', $tenant->id)
            ->where('created_at', '>=', $startDate)
            ->count();
            
        $validScans = ScanEvent::where('tenant_id', $tenant->id)
            ->where('status', 'valid')
            ->where('created_at', '>=', $startDate)
            ->count();
            
        $expiredScans = ScanEvent::where('tenant_id', $tenant->id)
            ->where('status', 'expired')
            ->where('created_at', '>=', $startDate)
            ->count();

        return [
            'total_scans' => $totalScans,
            'valid_scans' => $validScans,
            'expired_scans' => $expiredScans,
            'success_rate' => $totalScans > 0 ? round(($validScans / $totalScans) * 100, 2) : 0,
        ];
    }

    /**
     * Caută brățara în baza de date și returnează informațiile despre copil și sesiune
     */
    public function lookupBracelet(string $code, Tenant $tenant): array
    {
        $bracelet = Bracelet::where('code', $code)
            ->where('tenant_id', $tenant->id)
            ->with(['child.guardian'])
            ->first();

        if (!$bracelet) {
            return [
                'success' => false,
                'message' => 'Brățară nu a fost găsită',
                'bracelet' => null,
            ];
        }

        if ($bracelet->isAvailable()) {
            return [
                'success' => true,
                'message' => 'Brățară disponibilă - poate fi asignată unui copil nou',
                'bracelet' => $bracelet,
                'can_assign' => true,
            ];
        }

        if ($bracelet->isAssigned()) {
            // Verifică dacă copilul are o sesiune activă (ended_at NULL)
            $activeSession = PlaySession::where('child_id', $bracelet->child_id)
                ->whereNull('ended_at')
                ->with('intervals')
                ->first();

            $activePayload = null;
            if ($activeSession) {
                $currentInterval = $activeSession->intervals->whereStrict('ended_at', null)->sortByDesc('started_at')->first();
                $activePayload = [
                    'id' => $activeSession->id,
                    'started_at' => optional($activeSession->started_at)->toISOString(),
                    'status' => $activeSession->status ?? 'active',
                    'is_paused' => $activeSession->isPaused(),
                    'effective_seconds' => $activeSession->getEffectiveDurationSeconds(),
                    'current_interval_started_at' => $currentInterval && $currentInterval->started_at ? $currentInterval->started_at->toISOString() : null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Brățară asignată - poate fi folosită pentru sesiune',
                'bracelet' => $bracelet,
                'child' => $bracelet->child,
                'guardian' => $bracelet->child->guardian,
                'active_session' => $activePayload,
                'can_start_session' => true,
            ];
        }

        return [
            'success' => false,
            'message' => 'Brățară nu este disponibilă (pierdută sau deteriorată)',
            'bracelet' => $bracelet,
        ];
    }

    /**
     * Începe o sesiune de joacă pentru un copil
     */
    public function startPlaySession(Tenant $tenant, Child $child, Bracelet $bracelet): PlaySession
    {
        // Verifică dacă copilul are deja o sesiune activă
        $existingSession = PlaySession::where('child_id', $child->id)
            ->whereNull('ended_at')
            ->first();

        if ($existingSession) {
            throw new \Exception('Copilul are deja o sesiune activă');
        }

        // Verifică dacă brățara este asignată copilului
        if ($bracelet->child_id !== $child->id) {
            throw new \Exception('Brățara nu este asignată acestui copil');
        }

        $session = PlaySession::startSession($tenant, $child, $bracelet);

        ActionLogger::logSession('started', $session->id, [
            'child_id' => $child->id,
            'child_name' => $child->first_name . ' ' . $child->last_name,
            'bracelet_id' => $bracelet->id,
            'bracelet_code' => $bracelet->code,
        ]);

        return $session;
    }

    /**
     * Oprește o sesiune de joacă
     */
    public function stopPlaySession(int $sessionId): PlaySession
    {
        $session = PlaySession::findOrFail($sessionId);
        
        if (!$session->isActive()) {
            throw new \Exception('Sesiunea nu este activă');
        }

        $session = $session->endSession();

        ActionLogger::logSession('stopped', $sessionId, [
            'duration_minutes' => $session->getCurrentDurationMinutes(),
            'duration_formatted' => $session->getFormattedDuration(),
        ]);

        return $session;
    }

    /** Pune pe pauză o sesiune de joacă */
    public function pausePlaySession(int $sessionId): PlaySession
    {
        $session = PlaySession::findOrFail($sessionId);
        if (!$session->isActive()) {
            throw new \Exception('Sesiunea nu este activă');
        }
        if ($session->isPaused()) {
            return $session;
        }
        $session = $session->pause();
        ActionLogger::logSession('paused', $sessionId, [
            'effective_seconds' => $session->getEffectiveDurationSeconds(),
        ]);
        return $session;
    }

    /** Reia o sesiune de joacă pauzată */
    public function resumePlaySession(int $sessionId): PlaySession
    {
        $session = PlaySession::findOrFail($sessionId);
        if (!$session->isActive()) {
            throw new \Exception('Sesiunea nu este activă');
        }
        if (!$session->isPaused()) {
            return $session;
        }
        $session = $session->resume();
        ActionLogger::logSession('resumed', $sessionId, [
            'effective_seconds' => $session->getEffectiveDurationSeconds(),
        ]);
        return $session;
    }

    /** Stop session and unassign bracelet */
    public function stopAndUnassign(int $sessionId): PlaySession
    {
        $session = $this->stopPlaySession($sessionId);
        if ($session && $session->bracelet_id) {
            if ($this->bracelets) {
                $this->bracelets->markAvailable($session->bracelet_id);
            } else {
                $bracelet = \App\Models\Bracelet::find($session->bracelet_id);
                if ($bracelet) {
                    $bracelet->update([
                        'status' => 'available',
                        'child_id' => null,
                        'assigned_at' => null,
                    ]);
                }
            }
            ActionLogger::log('bracelet.unassigned', 'Bracelet', $session->bracelet_id, [
                'session_id' => $sessionId,
            ]);
        }
        return $session;
    }

    /**
     * Obține sesiunile active pentru un tenant
     */
    public function getActiveSessions(Tenant $tenant): array
    {
        return PlaySession::where('tenant_id', $tenant->id)
            ->whereNull('ended_at')
            ->with(['child.guardian', 'bracelet', 'intervals'])
            ->get()
            ->map(function ($session) {
                $child = $session->child;
                $guardian = $child ? $child->guardian : null;
                $childName = $child ? trim(($child->first_name ?? '') . ' ' . ($child->last_name ?? '')) : '-';
                $effectiveSeconds = $session->getEffectiveDurationSeconds();
                $currentInterval = $session->intervals->whereStrict('ended_at', null)->sortByDesc('started_at')->first();
                return [
                    'id' => $session->id,
                    'child_name' => $childName,
                    'parent_name' => $guardian->name ?? '-',
                    'started_at' => $session->started_at ? $session->started_at->toISOString() : null,
                    'duration' => $session->getFormattedDuration(),
                    'status' => $session->status ?? 'active',
                    'is_paused' => $session->isPaused(),
                    'effective_seconds' => $effectiveSeconds,
                    'current_interval_started_at' => $currentInterval && $currentInterval->started_at ? $currentInterval->started_at->toISOString() : null,
                    'bracelet_code' => $session->bracelet->code ?? null,
                    'estimated_price' => $session->calculatePrice(),
                    'formatted_estimated_price' => $session->getFormattedPrice(),
                ];
            })
            ->toArray();
    }

    /**
     * Obține statistici despre sesiuni pentru un tenant
     */
    public function getSessionStats(Tenant $tenant, int $days = 7): array
    {
        $startDate = now()->subDays($days);
        
        $totalSessions = PlaySession::where('tenant_id', $tenant->id)
            ->where('started_at', '>=', $startDate)
            ->count();
            
        $activeSessions = PlaySession::where('tenant_id', $tenant->id)
            ->whereNull('ended_at')
            ->count();
            
        $completedSessions = PlaySession::where('tenant_id', $tenant->id)
            ->whereNotNull('ended_at')
            ->where('started_at', '>=', $startDate)
            ->count();

        // Recalculează durata din started_at și ended_at pentru sesiunile închise
        $completedSessionsCollection = PlaySession::where('tenant_id', $tenant->id)
            ->whereNotNull('ended_at')
            ->where('started_at', '>=', $startDate)
            ->get();

        $totalPlayTime = $completedSessionsCollection->reduce(function ($carry, $session) {
            return $carry + $session->getCurrentDurationMinutes();
        }, 0);

        return [
            'total_sessions' => $totalSessions,
            'active_sessions' => $activeSessions,
            'completed_sessions' => $completedSessions,
            'total_play_time_minutes' => $totalPlayTime,
            'total_play_time_formatted' => $this->formatMinutes($totalPlayTime),
        ];
    }

    /**
     * Return last N completed sessions for a tenant
     */
    public function getRecentCompletedSessions(Tenant $tenant, int $limit = 3): array
    {
        $sessions = PlaySession::where('tenant_id', $tenant->id)
            ->whereNotNull('ended_at')
            ->with(['child.guardian', 'bracelet', 'intervals'])
            ->orderByDesc('ended_at')
            ->limit($limit)
            ->get();

        return $sessions->map(function ($session) {
            $child = $session->child;
            $childName = $child ? trim(($child->first_name ?? '') . ' ' . ($child->last_name ?? '')) : '-';
            return [
                'id' => $session->id,
                'child_name' => $childName,
                'started_at' => $session->started_at ? $session->started_at->toISOString() : null,
                'ended_at' => $session->ended_at ? $session->ended_at->toISOString() : null,
                'effective_seconds' => $session->getEffectiveDurationSeconds(),
                'duration_formatted' => $session->getFormattedDuration(),
                'bracelet_code' => $session->bracelet->code ?? null,
            ];
        })->toArray();
    }

    /**
     * Formatează minutele în format ore:minute
     */
    private function formatMinutes(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $remainingMinutes);
        }
        
        return sprintf('%dm', $remainingMinutes);
    }
}
