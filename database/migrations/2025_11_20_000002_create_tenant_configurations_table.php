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
        Schema::create('tenant_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
            $table->string('key');
            $table->text('value'); // JSON or text value
            $table->string('type')->nullable(); // Optional type hint (e.g., 'array', 'boolean', 'string')
            $table->text('description')->nullable();
            $table->timestamps();

            // Unique constraint: one configuration per key per tenant (or global if tenant_id is null)
            $table->unique(['tenant_id', 'key']);
            
            // Index on key for performance
            $table->index('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_configurations');
    }
};

