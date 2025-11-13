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
        Schema::create('fiscal_receipt_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('play_session_id')->constrained('play_sessions')->onDelete('cascade');
            $table->string('filename')->nullable(); // Numele fișierului generat (ex: bon_20231215143022.txt)
            $table->enum('status', ['success', 'error'])->default('success');
            $table->text('error_message')->nullable(); // Doar pentru erori
            $table->timestamps();
            
            // Index pentru performanță
            $table->index(['play_session_id', 'created_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiscal_receipt_logs');
    }
};
