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
        Schema::table('fiscal_receipt_logs', function (Blueprint $table) {
            $table->decimal('voucher_hours', 8, 2)->nullable()->after('error_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fiscal_receipt_logs', function (Blueprint $table) {
            $table->dropColumn('voucher_hours');
        });
    }
};
