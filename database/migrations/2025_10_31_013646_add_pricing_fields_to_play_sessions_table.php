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
        Schema::table('play_sessions', function (Blueprint $table) {
            $table->decimal('calculated_price', 10, 2)->nullable()->after('ended_at');
            $table->decimal('price_per_hour_at_calculation', 10, 2)->nullable()->after('calculated_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('play_sessions', function (Blueprint $table) {
            $table->dropColumn(['calculated_price', 'price_per_hour_at_calculation']);
        });
    }
};
