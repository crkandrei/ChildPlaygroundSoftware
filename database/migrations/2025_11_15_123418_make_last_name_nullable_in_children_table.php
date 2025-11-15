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
        // Modify last_name column to be nullable
        DB::statement('ALTER TABLE `children` MODIFY `last_name` VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert last_name column to NOT NULL
        // First, set any NULL values to empty string to avoid constraint violation
        DB::statement('UPDATE `children` SET `last_name` = "" WHERE `last_name` IS NULL');
        DB::statement('ALTER TABLE `children` MODIFY `last_name` VARCHAR(255) NOT NULL');
    }
};
