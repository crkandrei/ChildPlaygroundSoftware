<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Elimină constrângerea unique de pe email (dacă există)
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['email']);
            });
        } catch (\Exception $e) {
            // Ignoră dacă constrângerea nu există sau nu poate fi eliminată
        }
        
        // Modifică câmpul email să fie nullable
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reface email-ul obligatoriu
            $table->string('email')->nullable(false)->change();
            
            // Readaugă constrângerea unique
            // Notă: MySQL permite multiple NULL-uri cu unique constraint
            $table->unique('email');
        });
    }
};
