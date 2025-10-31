<?php

namespace App\Services;

use App\Models\PlaySession;
use App\Repositories\Contracts\ChildRepositoryInterface;
use App\Repositories\Contracts\PlaySessionRepositoryInterface;
use Carbon\Carbon;

class DashboardService
{
    public function __construct(
        private PlaySessionRepositoryInterface $sessions,
        private ChildRepositoryInterface $children
    )
    {
    }

    public function getStatsForTenant(int $tenantId): array
    {
        $now = now();
        $startOfDay = $now->copy()->startOfDay();

        $activeSessions = $this->sessions->countActiveSessionsByTenant($tenantId);
        $sessionsToday = $this->sessions->countSessionsStartedSince($tenantId, $startOfDay);
        $inProgressToday = $this->sessions->countActiveSessionsStartedSince($tenantId, $startOfDay);
        
        $todaySessions = $this->sessions->getSessionsSince($tenantId, $startOfDay);
        $totalMinutesToday = $todaySessions->reduce(fn($c, $s) => $c + $s->getCurrentDurationMinutes(), 0);
        $avgToday = $todaySessions->count() > 0 ? (int) floor($totalMinutesToday / $todaySessions->count()) : 0;

        $allSessions = $this->sessions->getAllByTenant($tenantId);
        $totalMinutesAll = $allSessions->reduce(fn($c, $s) => $c + $s->getCurrentDurationMinutes(), 0);
        $avgAll = $allSessions->count() > 0 ? (int) floor($totalMinutesAll / $allSessions->count()) : 0;

        return [
            'active_sessions' => $activeSessions,
            'sessions_today' => $sessionsToday,
            'sessions_today_in_progress' => $inProgressToday,
            'avg_session_today_minutes' => $avgToday,
            'avg_session_total_minutes' => $avgAll,
            'total_time_today' => $this->formatMinutes($totalMinutesToday),
        ];
    }

    public function getActiveSessions(int $tenantId): array
    {
        return $this->sessions->getActiveSessionsWithRelations($tenantId)
            ->map(function ($session) {
                $child = $session->child;
                $guardian = $child ? $child->guardian : null;
                $childName = $child ? trim(($child->first_name ?? '') . ' ' . ($child->last_name ?? '')) : '-';
                return [
                    'id' => $session->id,
                    'child_name' => $childName,
                    'parent_name' => $guardian->name ?? '-',
                    'started_at' => $session->started_at ? $session->started_at->toISOString() : null,
                    'duration' => $session->getFormattedDuration(),
                    'bracelet_code' => $session->bracelet->code ?? null,
                ];
            })
            ->toArray();
    }

    public function getReports(int $tenantId, ?string $startDate = null, ?string $endDate = null, ?array $weekdays = null): array
    {
        $now = now();
        $start = $startDate ? Carbon::parse($startDate)->startOfDay() : $now->copy()->startOfDay();
        $end = $endDate ? Carbon::parse($endDate)->endOfDay() : $now->copy()->endOfDay();
        if ($end->lessThan($start)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        // Get sessions between dates
        $sessionsQuery = PlaySession::where('tenant_id', $tenantId)
            ->where('started_at', '>=', $start)
            ->where('started_at', '<=', $end);
        
        // Filter by weekdays if specified
        if ($weekdays && !empty($weekdays)) {
            // Convert weekday numbers to array of integers
            $weekdaysArray = array_map('intval', $weekdays);
            // Use SQL DAYOFWEEK function: 1=Sunday, 2=Monday, ..., 7=Saturday
            // But Carbon uses 0=Sunday, 1=Monday, ..., 6=Saturday
            // MySQL DAYOFWEEK returns 1-7, so we need to adjust
            $mysqlWeekdays = array_map(function($day) {
                // Convert Carbon dayOfWeek (0-6) to MySQL DAYOFWEEK (1-7)
                // Carbon: 0=Sunday, 1=Monday, ..., 6=Saturday
                // MySQL: 1=Sunday, 2=Monday, ..., 7=Saturday
                return $day + 1;
            }, $weekdaysArray);
            
            // Use whereRaw with bindings for security
            $placeholders = implode(',', array_fill(0, count($mysqlWeekdays), '?'));
            $sessionsQuery->whereRaw("DAYOFWEEK(started_at) IN ({$placeholders})", $mysqlWeekdays);
        }
        
        $sessionsToday = $sessionsQuery->get();
        
        $totalToday = $sessionsToday->count();

        $buckets = ['<1h' => 0, '1-2h' => 0, '2-3h' => 0, '>3h' => 0];
        foreach ($sessionsToday as $s) {
            $mins = $s->getCurrentDurationMinutes();
            if ($mins < 60) $buckets['<1h']++;
            elseif ($mins < 120) $buckets['1-2h']++;
            elseif ($mins < 180) $buckets['2-3h']++;
            else $buckets['>3h']++;
        }
        $bucketPerc = [];
        foreach ($buckets as $k => $v) {
            $bucketPerc[$k] = $totalToday > 0 ? round(($v / $totalToday) * 100, 1) : 0.0;
        }

        $children = $this->children->getAllWithBirthdateByTenant($tenantId);
        $avgAgeYears = 0;
        $avgAgeMonths = 0;
        if ($children->count() > 0) {
            $totalMonths = $children->reduce(function ($carry, $c) {
                try {
                    $birthDate = \Carbon\Carbon::parse($c->birth_date);
                    $now = now();
                    $diff = $birthDate->diff($now);
                    return $carry + ($diff->y * 12) + $diff->m;
                } catch (\Throwable) {
                    return $carry;
                }
            }, 0);
            $avgMonths = (int) round($totalMonths / $children->count());
            $avgAgeYears = (int) ($avgMonths / 12);
            $avgAgeMonths = $avgMonths % 12;
        }

        // Unique vs recurring visitors within the selected range
        $byChild = [];
        foreach ($sessionsToday as $sess) {
            if (!$sess->child_id) { continue; }
            $byChild[$sess->child_id] = ($byChild[$sess->child_id] ?? 0) + 1;
        }
        $uniqueVisitors = 0; // exactly one session in range
        $recurringVisitors = 0; // two or more sessions in range
        foreach ($byChild as $count) {
            if ($count <= 1) { $uniqueVisitors++; }
            else { $recurringVisitors++; }
        }
        $totalVisitors = max(1, $uniqueVisitors + $recurringVisitors);
        $visitorDist = [
            'unique' => ['count' => $uniqueVisitors, 'percent' => round(($uniqueVisitors / $totalVisitors) * 100, 1)],
            'recurring' => ['count' => $recurringVisitors, 'percent' => round(($recurringVisitors / $totalVisitors) * 100, 1)],
        ];

        // Hourly traffic: count sessions by hour of started_at (0-23)
        $hourlyTraffic = array_fill(0, 24, 0);
        foreach ($sessionsToday as $sess) {
            if ($sess->started_at) {
                $hour = (int) $sess->started_at->format('H');
                $hourlyTraffic[$hour]++;
            }
        }

        return [
            'total_today' => $totalToday,
            'buckets_today' => [
                'lt_1h' => ['count' => $buckets['<1h'], 'percent' => $bucketPerc['<1h']],
                'h1_2' => ['count' => $buckets['1-2h'], 'percent' => $bucketPerc['1-2h']],
                'h2_3' => ['count' => $buckets['2-3h'], 'percent' => $bucketPerc['2-3h']],
                'gt_3h' => ['count' => $buckets['>3h'], 'percent' => $bucketPerc['>3h']],
            ],
            'avg_child_age_years' => $avgAgeYears,
            'avg_child_age_months' => $avgAgeMonths,
            'visitor_distribution' => $visitorDist,
            'hourly_traffic' => $hourlyTraffic,
        ];
    }

    private function formatMinutes(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $rem = $minutes % 60;
        return sprintf('%dh %dm', $hours, $rem);
    }
}


