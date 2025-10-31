<?php

namespace App\Repositories\Contracts;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PlaySessionRepositoryInterface
{
    public function countActiveSessionsByTenant(int $tenantId): int;
    
    public function countSessionsStartedSince(int $tenantId, Carbon $since): int;

    public function countActiveSessionsStartedSince(int $tenantId, Carbon $since): int;

    public function getSessionsSince(int $tenantId, Carbon $since): Collection;

    public function getSessionsBetween(int $tenantId, Carbon $start, Carbon $end): Collection;

    public function getAllByTenant(int $tenantId): Collection;

    public function getActiveSessionsWithRelations(int $tenantId): Collection;

    /**
     * Paginate sessions with search/sort.
     * Returns [total => int, rows => Collection<array>]
     */
    public function paginateSessions(
        int $tenantId,
        int $page,
        int $perPage,
        ?string $search,
        string $sortBy,
        string $sortDir
    ): array;
}


