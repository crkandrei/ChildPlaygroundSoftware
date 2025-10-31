<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // If the column does not exist (older schema), add it including 'paused'
        if (!Schema::hasColumn('play_sessions', 'status')) {
            Schema::table('play_sessions', function (Blueprint $table) {
                $table->enum('status', ['active','paused','completed','cancelled'])->default('active');
            });
            return;
        }

        // Column exists – attempt to alter for MySQL to include 'paused'; for SQLite/others, skip
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE play_sessions MODIFY COLUMN status ENUM('active','paused','completed','cancelled') NOT NULL DEFAULT 'active'");
        }
    }

    public function down(): void
    {
        // If we added the column in up(), drop it on rollback
        if (!Schema::hasColumn('play_sessions', 'status')) {
            return;
        }

        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            // Revert to previous enum without 'paused'
            DB::statement("ALTER TABLE play_sessions MODIFY COLUMN status ENUM('active','completed','cancelled') NOT NULL DEFAULT 'active'");
        }
    }
};


