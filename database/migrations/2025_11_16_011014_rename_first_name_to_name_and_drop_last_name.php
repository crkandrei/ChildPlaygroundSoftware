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
            DB::statement('ALTER TABLE `children` CHANGE `first_name` `name` VARCHAR(255) NOT NULL');
        } else {
            Schema::table('children', function (Blueprint $table) {
                $table->renameColumn('first_name', 'name');
            });
        }

        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('children', function (Blueprint $table) {
                $table->dropColumn('last_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('children', function (Blueprint $table) {
                $table->string('last_name')->nullable()->after('name');
            });
        }

        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `children` CHANGE `name` `first_name` VARCHAR(255) NOT NULL');
        } else {
            Schema::table('children', function (Blueprint $table) {
                $table->renameColumn('name', 'first_name');
            });
        }
    }
};

