<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface AuditLogRepositoryInterface
{
    public function latestByTenant(int $tenantId, int $limit = 20): Collection;
}




