<?php

namespace App\Repositories\Eloquent;

use App\Models\Child;
use App\Repositories\Contracts\ChildRepositoryInterface;
use Illuminate\Support\Collection;

class ChildRepository implements ChildRepositoryInterface
{
    public function getAllWithBirthdateByTenant(int $tenantId): Collection
    {
        return Child::where('tenant_id', $tenantId)
            ->whereNotNull('birth_date')
            ->get();
    }
}




