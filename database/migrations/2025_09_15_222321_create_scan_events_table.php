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
        Schema::create('scan_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('bracelet_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('child_id')->nullable()->constrained()->onDelete('set null');
            $table->string('code_used'); // Codul scanat (random în POC)
            $table->enum('status', ['pending', 'valid', 'invalid', 'expired'])->default('pending');
            $table->timestamp('scanned_at');
            $table->timestamp('expires_at'); // TTL pentru cod
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index pentru performanță
            $table->index(['tenant_id', 'scanned_at']);
            $table->index(['code_used', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_events');
    }
};
