<?php

namespace App\Repositories\Eloquent;

use App\Models\PlaySession;
use App\Repositories\Contracts\PlaySessionRepositoryInterface;
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

    public function getActiveSessionsWithRelations(int $tenantId): Collection
    {
        return PlaySession::where('tenant_id', $tenantId)
            ->whereNull('ended_at')
            ->with(['child.guardian'])
            ->get();
    }

    public function paginateSessions(
        int $tenantId,
        int $page,
        int $perPage,
        ?string $search,
        string $sortBy,
        string $sortDir
    ): array {
        $sortable = [
            'child_name' => 'children.name',
            'guardian_name' => 'guardians.name',
            'guardian_phone' => 'guardians.phone',
            'started_at' => 'play_sessions.started_at',
            'ended_at' => 'play_sessions.ended_at',
        ];
        $sortColumn = $sortable[$sortBy] ?? 'play_sessions.started_at';

        $todayStart = \Carbon\Carbon::today()->startOfDay();
        $todayEnd = \Carbon\Carbon::today()->endOfDay();
        
        $query = PlaySession::query()
            ->where('play_sessions.tenant_id', $tenantId)
            ->whereBetween('play_sessions.started_at', [$todayStart, $todayEnd])
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
                'play_sessions.paid_at',
                'play_sessions.payment_status',
                'play_sessions.voucher_hours',
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

        $rows = $query
            ->orderByRaw('play_sessions.ended_at IS NULL DESC') // Active sessions first
            ->orderByRaw($sortColumn . ' ' . $sortDir)
            ->forPage($page, $perPage)
            ->get()
            ->map(function ($row) {
                $childName = $row->child_name ?? '';
                // Load full session to compute effective time and pause state
                $ps = \App\Models\PlaySession::with(['intervals', 'products'])->find($row->id);
                
                // For ended sessions, use total effective time
                // For active sessions, use ONLY closed intervals (frontend will add current interval)
                if ($row->ended_at) {
                    $effectiveSeconds = $ps ? $ps->getEffectiveDurationSeconds() : 0;
                } else {
                    $effectiveSeconds = $ps ? $ps->getClosedIntervalsDurationSeconds() : 0;
                }
                
                $isPaused = $ps ? $ps->isPaused() : false;
                $currentStart = null;
                if ($ps && !$row->ended_at) {
                    $open = $ps->intervals()->whereNull('ended_at')->latest('started_at')->first();
                    $currentStart = $open && $open->started_at ? $open->started_at->toISOString() : null;
                }
                
                // Calculate price - use saved price for completed sessions, calculate for active ones
                $price = null;
                $formattedPrice = null;
                if ($row->ended_at && $row->calculated_price !== null) {
                    // Use saved price for completed sessions
                    $price = (float) $row->calculated_price;
                    $formattedPrice = $ps ? $ps->getFormattedPrice() : number_format($price, 2, '.', '') . ' RON';
                } elseif ($ps) {
                    // Calculate estimated price for active sessions
                    $price = $ps->calculatePrice();
                    $formattedPrice = $ps->getFormattedPrice();
                }
                
                // Get products total price
                $productsPrice = 0;
                $productsFormattedPrice = '';
                if ($ps) {
                    $productsPrice = $ps->getProductsTotalPrice();
                    if ($productsPrice > 0) {
                        $productsFormattedPrice = number_format($productsPrice, 2, '.', '') . ' RON';
                    }
                }
                
                return [
                    'id' => $row->id,
                    'child_name' => $childName,
                    'guardian_name' => $row->guardian_name,
                    'guardian_phone' => $row->guardian_phone,
                    'started_at' => optional($row->started_at)->toISOString(),
                    'ended_at' => optional($row->ended_at)->toISOString(),
                    'status' => $row->status,
                    'is_paused' => $isPaused,
                    'effective_seconds' => $effectiveSeconds,
                    'current_interval_started_at' => $currentStart,
                    'price' => $price,
                    'formatted_price' => $formattedPrice,
                    'products_price' => (float) $productsPrice,
                    'products_formatted_price' => $productsFormattedPrice,
                    'price_per_hour_at_calculation' => $row->price_per_hour_at_calculation ? (float) $row->price_per_hour_at_calculation : null,
                    'is_birthday' => (bool) $row->is_birthday,
                    'paid_at' => optional($row->paid_at)->toISOString(),
                    'is_paid' => !is_null($row->paid_at),
                    'payment_status' => $row->payment_status ?? null,
                    'voucher_hours' => $row->voucher_hours ? (float) $row->voucher_hours : null,
                ];
            });

        return [ 'total' => $total, 'rows' => $rows ];
    }
}


