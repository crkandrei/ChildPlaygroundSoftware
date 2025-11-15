<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify birth_date column to be nullable
        DB::statement('ALTER TABLE `children` MODIFY `birth_date` DATE NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert birth_date column to NOT NULL
        // First, set any NULL values to a default date to avoid constraint violation
        // Using a date in the past (e.g., 2000-01-01) as default
        DB::statement('UPDATE `children` SET `birth_date` = "2000-01-01" WHERE `birth_date` IS NULL');
        DB::statement('ALTER TABLE `children` MODIFY `birth_date` DATE NOT NULL');
    }
};
