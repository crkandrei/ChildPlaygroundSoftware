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
            DB::statement('ALTER TABLE `children` MODIFY `birth_date` DATE NULL');
        } else {
            Schema::table('children', function (Blueprint $table) {
                $table->date('birth_date')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('UPDATE `children` SET `birth_date` = "2000-01-01" WHERE `birth_date` IS NULL');
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `children` MODIFY `birth_date` DATE NOT NULL');
        } else {
            Schema::table('children', function (Blueprint $table) {
                $table->date('birth_date')->nullable(false)->change();
            });
        }
    }
};
