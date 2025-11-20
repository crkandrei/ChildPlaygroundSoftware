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
        Schema::create('weekly_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->tinyInteger('day_of_week')->comment('0=Luni, 6=Duminică');
            $table->decimal('hourly_rate', 10, 2);
            $table->timestamps();

            // Unique constraint: un tenant poate avea doar un tarif per zi a săptămânii
            $table->unique(['tenant_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_rates');
    }
};


