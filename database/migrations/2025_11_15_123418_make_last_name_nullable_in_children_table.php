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
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `children` MODIFY `last_name` VARCHAR(255) NULL');
        } else {
            Schema::table('children', function (Blueprint $table) {
                $table->string('last_name')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('UPDATE `children` SET `last_name` = "" WHERE `last_name` IS NULL');
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `children` MODIFY `last_name` VARCHAR(255) NOT NULL');
        } else {
            Schema::table('children', function (Blueprint $table) {
                $table->string('last_name')->nullable(false)->change();
            });
        }
    }
};
