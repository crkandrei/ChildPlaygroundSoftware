<?php

namespace App\Repositories\Eloquent;

use App\Models\Bracelet;
use App\Repositories\Contracts\BraceletRepositoryInterface;

class BraceletRepository implements BraceletRepositoryInterface
{
    public function findById(int $id): ?Bracelet
    {
        return Bracelet::find($id);
    }

    public function markAvailable(int $braceletId): void
    {
        $bracelet = Bracelet::find($braceletId);
        if ($bracelet) {
            $bracelet->update([
                'status' => 'available',
                'child_id' => null,
                'assigned_at' => null,
            ]);
        }
    }
}




