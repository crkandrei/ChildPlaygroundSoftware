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
        Schema::table('guardians', function (Blueprint $table) {
            $table->timestamp('terms_accepted_at')->nullable()->after('notes');
            $table->timestamp('gdpr_accepted_at')->nullable()->after('terms_accepted_at');
            $table->string('terms_version')->nullable()->after('gdpr_accepted_at');
            $table->string('gdpr_version')->nullable()->after('terms_version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guardians', function (Blueprint $table) {
            $table->dropColumn([
                'terms_accepted_at',
                'gdpr_accepted_at',
                'terms_version',
                'gdpr_version',
            ]);
        });
    }
};
