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
        // Add columns ofnly if they do not already exist
        if (!Schema::hasColumn('children', 'first_name')) {
            Schema::table('children', function (Blueprint $table) {
                $table->string('first_name')->nullable()->after('guardian_id');
            });
        }

        if (!Schema::hasColumn('children', 'last_name')) {
            Schema::table('children', function (Blueprint $table) {
                $table->string('last_name')->nullable()->after('first_name');
            });
        }

        if (!Schema::hasColumn('children', 'birth_date')) {
            Schema::table('children', function (Blueprint $table) {
                $table->date('birth_date')->nullable()->after('last_name');
            });
        }

        if (!Schema::hasColumn('children', 'allergies')) {
            Schema::table('children', function (Blueprint $table) {
                $table->text('allergies')->nullable()->after('birth_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Best-effort cleanup; may require DBAL for some drivers
        Schema::table('children', function (Blueprint $table) {
            if (Schema::hasColumn('children', 'allergies')) {
                $table->dropColumn('allergies');
            }
        });

        Schema::table('children', function (Blueprint $table) {
            if (Schema::hasColumn('children', 'birth_date')) {
                $table->dropColumn('birth_date');
            }
        });

        Schema::table('children', function (Blueprint $table) {
            if (Schema::hasColumn('children', 'last_name')) {
                $table->dropColumn('last_name');
            }
        });

        Schema::table('children', function (Blueprint $table) {
            if (Schema::hasColumn('children', 'first_name')) {
                $table->dropColumn('first_name');
            }
        });
    }
};


