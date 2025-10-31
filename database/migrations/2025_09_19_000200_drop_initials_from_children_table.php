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
        if (Schema::hasColumn('children', 'initials')) {
            Schema::table('children', function (Blueprint $table) {
                $table->dropColumn('initials');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('children', 'initials')) {
            Schema::table('children', function (Blueprint $table) {
                $table->string('initials')->nullable()->after('allergies');
            });
        }
    }
};


