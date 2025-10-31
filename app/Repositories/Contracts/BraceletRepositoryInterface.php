<?php

namespace App\Repositories\Contracts;

use App\Models\Bracelet;

interface BraceletRepositoryInterface
{
    public function findById(int $id): ?Bracelet;
    public function markAvailable(int $braceletId): void;
}




