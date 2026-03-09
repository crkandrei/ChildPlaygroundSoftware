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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('agent_id')->unique();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->string('activation_code')->unique();
            $table->string('location_name')->nullable();
            $table->string('printer_serial_number')->nullable();
            $table->string('printer_model')->nullable();
            $table->string('printer_id')->nullable();
            $table->enum('printer_status', ['online', 'offline'])->default('offline');
            $table->string('agent_version')->nullable();
            $table->timestamp('last_heartbeat_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tenant_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
