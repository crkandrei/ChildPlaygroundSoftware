<?php

namespace App\Repositories\Eloquent;

use App\Models\PlaySession;
use App\Models\TenantConfiguration;
use App\Repositories\Contracts\PlaySessionRepositoryInterface;
use App\Services\PricingService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PlaySessionRepository implements PlaySessionRepositoryInterface
{
    public function countActiveSessionsByTenant(int $tenantId): int
    {
        return PlaySession::where('tenant_id', $tenantId)
            ->whereNull('ended_at')
            ->count();
    }

    public function countSessionsStartedSince(int $tenantId, Carbon $since): int
    {
        return PlaySession::where('tenant_id', $tenantId)
            ->where('started_at', '>=', $since)
            ->count();
    }

    public function countActiveSessionsStartedSince(int $tenantId, Carbon $since): int
    {
        return PlaySession::where('tenant_id', $tenantId)
            ->where('started_at', '>=', $since)
            ->whereNull('ended_at')
            ->count();
    }

    public function getSessionsSince(int $tenantId, Carbon $since): Collection
    {
        return PlaySession::where('tenant_id', $tenantId)
            ->where('started_at', '>=', $since)
            ->get();
    }

    public function getSessionsBetween(int $tenantId, Carbon $start, Carbon $end): Collection
    {
        return PlaySession::where('tenant_id', $tenantId)
            ->where('started_at', '>=', $start)
            ->where('started_at', '<=', $end)
            ->get();
    }

    public function getAllByTenant(int $tenantId): Collection
    {
        return PlaySession::where('tenant_id', $tenantId)->get();
    }

    public function getActiveSessionsWithRelations(int $tenantId, int $limit = 100): Collection
    {
        $sessions = PlaySession::where('tenant_id', $tenantId)
            ->whereNull('ended_at')
            ->with(['child.guardian'])
            ->limit($limit)
            ->get();

        if ($sessions->count() >= $limit) {
            \Illuminate\Support\Facades\Log::warning(
                "getActiveSessionsWithRelations: LIMIT atins ({$limit}) pentru tenant {$tenantId}. Posibil sesiuni blocate."
            );
        }

        return $sessions;
    }

    public function paginateSessions(
        int $tenantId,
        int $page,
        int $perPage,
        ?string $search,
        string $sortBy,
        string $sortDir,
        Carbon $date
    ): array {
        $sortable = [
            'child_name' => 'children.name',
            'guardian_name' => 'guardians.name',
            'guardian_phone' => 'guardians.phone',
            'started_at' => 'play_sessions.started_at',
            'ended_at' => 'play_sessions.ended_at',
        ];
        $sortColumn = $sortable[$sortBy] ?? 'play_sessions.started_at';

        $dateStart = $date->copy()->startOfDay();
        $dateEnd = $date->copy()->endOfDay();

        $query = PlaySession::query()
            ->where('play_sessions.tenant_id', $tenantId)
            ->whereBetween('play_sessions.started_at', [$dateStart, $dateEnd])
            ->leftJoin('children', 'children.id', '=', 'play_sessions.child_id')
            ->leftJoin('guardians', 'guardians.id', '=', 'children.guardian_id')
            ->select([
                'play_sessions.id',
                'play_sessions.started_at',
                'play_sessions.ended_at',
                'play_sessions.status',
                'play_sessions.calculated_price',
                'play_sessions.price_per_hour_at_calculation',
                'play_sessions.is_birthday',
                'play_sessions.is_jungle',
                'play_sessions.paid_at',
                'play_sessions.payment_status',
                'play_sessions.voucher_hours',
                'play_sessions.tenant_id',
                'play_sessions.child_id',
                'children.name as child_name',
                'guardians.name as guardian_name',
                'guardians.phone as guardian_phone',
            ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('children.name', 'like', "%{$search}%")
                    ->orWhere('guardians.name', 'like', "%{$search}%")
                    ->orWhere('guardians.phone', 'like', "%{$search}%");
            });
        }

        $total = (clone $query)->count();

        // ✅ M3: pauseThreshold calculat O SINGURĂ DATĂ per request, nu per rând
        $pauseThreshold = TenantConfiguration::getPauseWarningThresholdMinutes($tenantId);

        // ✅ C1: eager load intervals, products, tenant — 3 queries IN, nu N queries find()
        $rows = $query
            ->with(['intervals', 'products', 'tenant'])
            ->orderByRaw('play_sessions.ended_at IS NULL DESC')
            ->orderByRaw($sortColumn . ' ' . $sortDir)
            ->forPage($page, $perPage)
            ->get()
            ->map(function ($ps) use ($pauseThreshold) {
                // ✅ C1: durata calculată din intervals deja eager-loaded — fără query suplimentar
                if ($ps->ended_at) {
                    $effectiveSeconds = $ps->getEffectiveDurationSeconds();
                } else {
                    $effectiveSeconds = $ps->getClosedIntervalsDurationSeconds();
                }

                $isPaused = $ps->isPaused();
                $currentStart = null;
                $lastPauseEnd = null;

                if (!$ps->ended_at) {
                    if ($isPaused) {
                        // ✅ C1: filtrare în PHP pe colecția eager-loaded, fără query
                        $lastClosedInterval = $ps->intervals
                            ->filter(fn($i) => $i->ended_at !== null)
                            ->sortByDesc('ended_at')
                            ->first();
                        if ($lastClosedInterval && $lastClosedInterval->ended_at) {
                            $lastPauseEnd = $lastClosedInterval->ended_at->toISOString();
                        }
                    } else {
                        $open = $ps->intervals
                            ->filter(fn($i) => $i->ended_at === null)
                            ->sortByDesc('started_at')
                            ->first();
                        if ($open && $open->started_at) {
                            $currentStart = $open->started_at->toISOString();
                        }
                    }
                }

                $price = null;
                $formattedPrice = null;
                if ($ps->ended_at && $ps->calculated_price !== null) {
                    $price = (float) $ps->calculated_price;
                    $formattedPrice = $ps->getFormattedPrice();
                } else {
                    $price = $ps->calculatePrice();
                    $formattedPrice = $ps->getFormattedPrice();
                }

                $productsPrice = $ps->getProductsTotalPrice();
                $productsFormattedPrice = $productsPrice > 0
                    ? number_format($productsPrice, 2, '.', '') . ' RON'
                    : '';

                // ✅ C1: tenant e deja eager-loaded, fără query suplimentar
                $canToggleJungle = false;
                if ($ps->tenant) {
                    $pricingService = app(PricingService::class);
                    $sessionDate = $ps->started_at ? Carbon::parse($ps->started_at) : now();
                    $canToggleJungle = $pricingService->isJungleSessionAllowed($ps->tenant, $sessionDate);
                }

                $currentPauseMinutes = 0;
                if ($isPaused && !$ps->ended_at) {
                    $currentPauseMinutes = $ps->getCurrentPauseMinutes();
                }

                // ✅ M3: $pauseThreshold vine din afara map()
                $hasLongPause = $isPaused && !$ps->ended_at && $currentPauseMinutes >= $pauseThreshold;
                $currentPauseExceedsThreshold = $currentPauseMinutes >= $pauseThreshold;

                return [
                    'id' => $ps->id,
                    'child_name' => $ps->child_name ?? '',
                    'guardian_name' => $ps->guardian_name,
                    'guardian_phone' => $ps->guardian_phone,
                    'started_at' => optional($ps->started_at)->toISOString(),
                    'ended_at' => optional($ps->ended_at)->toISOString(),
                    'status' => $ps->status,
                    'is_paused' => $isPaused,
                    'effective_seconds' => $effectiveSeconds,
                    'current_interval_started_at' => $currentStart,
                    'last_pause_end' => $lastPauseEnd,
                    'price' => $price,
                    'formatted_price' => $formattedPrice,
                    'products_price' => (float) $productsPrice,
                    'products_formatted_price' => $productsFormattedPrice,
                    'price_per_hour_at_calculation' => $ps->price_per_hour_at_calculation
                        ? (float) $ps->price_per_hour_at_calculation
                        : null,
                    'is_birthday' => (bool) $ps->is_birthday,
                    'is_jungle' => (bool) ($ps->is_jungle ?? false),
                    'can_toggle_jungle' => $canToggleJungle,
                    'current_pause_minutes' => $currentPauseMinutes,
                    'has_long_pause' => $hasLongPause,
                    'current_pause_exceeds_threshold' => $currentPauseExceedsThreshold,
                    'pause_threshold' => (int) $pauseThreshold,
                    'paid_at' => optional($ps->paid_at)->toISOString(),
                    'is_paid' => !is_null($ps->paid_at),
                    'payment_status' => $ps->payment_status ?? null,
                    'voucher_hours' => $ps->voucher_hours ? (float) $ps->voucher_hours : null,
                ];
            });

        return ['total' => $total, 'rows' => $rows];
    }
}


