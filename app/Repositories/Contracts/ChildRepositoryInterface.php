<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ChildRepositoryInterface
{
    public function getAllWithBirthdateByTenant(int $tenantId): Collection;
}




