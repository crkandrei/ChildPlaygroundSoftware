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
            // Ensure single-column indexes exist so foreign keys remain valid
            $table->index('tenant_id');
            $table->index('child_id');
            $table->index('bracelet_id');

            // Drop composite indexes that include the status column
            try { $table->dropIndex('play_sessions_tenant_id_status_index'); } catch (\Throwable $e) {}
            try { $table->dropIndex('play_sessions_child_id_status_index'); } catch (\Throwable $e) {}
            try { $table->dropIndex('play_sessions_bracelet_id_status_index'); } catch (\Throwable $e) {}

            // Drop unnecessary columns
            $table->dropColumn(['duration_minutes', 'status', 'notes']);

            // Drop created_at and updated_at timestamps
            $table->dropTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('play_sessions', function (Blueprint $table) {
            // Re-add timestamps
            $table->timestamps();

            // Re-add removed columns
            $table->integer('duration_minutes')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->text('notes')->nullable();

            // Recreate composite indexes involving status
            $table->index(['tenant_id', 'status']);
            $table->index(['child_id', 'status']);
            $table->index(['bracelet_id', 'status']);
        });
    }
};


