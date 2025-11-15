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
        Schema::table('fiscal_receipt_logs', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['play_session_id']);
        });
        
        // Make play_session_id nullable using raw SQL
        DB::statement('ALTER TABLE fiscal_receipt_logs MODIFY play_session_id BIGINT UNSIGNED NULL');
        
        Schema::table('fiscal_receipt_logs', function (Blueprint $table) {
            // Add type field to distinguish between session receipts and Z reports
            $table->enum('type', ['session', 'z_report'])->default('session')->after('id');
            
            // Add tenant_id for Z reports (which don't have a play_session)
            $table->foreignId('tenant_id')->nullable()->after('play_session_id')->constrained('tenants')->onDelete('cascade');
            
            // Re-add foreign key constraint for play_session_id (nullable)
            $table->foreign('play_session_id')->references('id')->on('play_sessions')->onDelete('cascade');
            
            // Update indexes
            $table->index(['type', 'created_at']);
            $table->index(['tenant_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fiscal_receipt_logs', function (Blueprint $table) {
            // Drop new indexes
            $table->dropIndex(['type', 'created_at']);
            $table->dropIndex(['tenant_id', 'created_at']);
            
            // Drop tenant_id foreign key and column
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
            
            // Drop type column
            $table->dropColumn('type');
            
            // Restore play_session_id to not nullable
            $table->dropForeign(['play_session_id']);
        });
        
        // Make play_session_id not nullable using raw SQL
        DB::statement('ALTER TABLE fiscal_receipt_logs MODIFY play_session_id BIGINT UNSIGNED NOT NULL');
        
        Schema::table('fiscal_receipt_logs', function (Blueprint $table) {
            $table->foreign('play_session_id')->references('id')->on('play_sessions')->onDelete('cascade');
        });
    }
};
