<?php

namespace App\Console\Commands;

use App\Models\PreCheckinToken;
use Illuminate\Console\Command;

class CleanupPreCheckinTokens extends Command
{
    protected $signature = 'pre-checkin:cleanup';
    protected $description = 'Delete expired and used pre-checkin tokens older than 24 hours';

    public function handle(): int
    {
        $deleted = PreCheckinToken::where(function ($q) {
            // Expired tokens older than 24h
            $q->where('expires_at', '<', now()->subDay());
        })->orWhere(function ($q) {
            // Used tokens older than 24h
            $q->whereNotNull('used_at')
              ->where('used_at', '<', now()->subDay());
        })->delete();

        $this->info("Deleted {$deleted} stale pre-checkin token(s).");

        return Command::SUCCESS;
    }
}
