<?php

namespace App\Repositories\Eloquent;

use App\Models\AuditLog;
use App\Repositories\Contracts\AuditLogRepositoryInterface;
use Illuminate\Support\Collection;

class AuditLogRepository implements AuditLogRepositoryInterface
{
    public function latestByTenant(int $tenantId, int $limit = 20): Collection
    {
        return AuditLog::where('tenant_id', $tenantId)
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }
}




