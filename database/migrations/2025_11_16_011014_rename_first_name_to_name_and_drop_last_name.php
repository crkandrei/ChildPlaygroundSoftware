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
        // Redenumește coloana first_name în name
        DB::statement('ALTER TABLE `children` CHANGE `first_name` `name` VARCHAR(255) NOT NULL');
        
        // Șterge coloana last_name
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn('last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Adaugă înapoi coloana last_name
        Schema::table('children', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
        });
        
        // Redenumește înapoi coloana name în first_name
        DB::statement('ALTER TABLE `children` CHANGE `name` `first_name` VARCHAR(255) NOT NULL');
    }
};

