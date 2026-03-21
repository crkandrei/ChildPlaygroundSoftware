<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('play_sessions', function (Blueprint $table) {
            $table->index(['tenant_id', 'started_at'], 'play_sessions_tenant_started_at_index');
            $table->index(['tenant_id', 'ended_at'], 'play_sessions_tenant_ended_at_index');
            $table->index(['tenant_id', 'paid_at'], 'play_sessions_tenant_paid_at_index');
            $table->index(['bracelet_code', 'tenant_id'], 'play_sessions_bracelet_code_tenant_index');
        });

        Schema::table('children', function (Blueprint $table) {
            $table->index(['tenant_id', 'name'], 'children_tenant_name_index');
        });
    }

    public function down(): void
    {
        Schema::table('play_sessions', function (Blueprint $table) {
            $table->dropIndex('play_sessions_tenant_started_at_index');
            $table->dropIndex('play_sessions_tenant_ended_at_index');
            $table->dropIndex('play_sessions_tenant_paid_at_index');
            $table->dropIndex('play_sessions_bracelet_code_tenant_index');
        });

        Schema::table('children', function (Blueprint $table) {
            $table->dropIndex('children_tenant_name_index');
        });
    }
};
