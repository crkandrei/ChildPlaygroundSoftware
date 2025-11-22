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
        Schema::create('play_session_intervals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('play_session_id')->constrained('play_sessions')->onDelete('cascade');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            // Duration in seconds for closed intervals (null while open)
            $table->integer('duration_seconds')->nullable();
            $table->timestamps();

            $table->index(['play_session_id', 'started_at']);
            $table->index(['play_session_id', 'ended_at']);
        });

        // Backfill existing sessions into a single interval each
        $sessions = DB::table('play_sessions')->select('id', 'started_at', 'ended_at')->get();
        $now = now();
        foreach ($sessions as $s) {
            $started = $s->started_at ? \Carbon\Carbon::parse($s->started_at) : null;
            $ended = $s->ended_at ? \Carbon\Carbon::parse($s->ended_at) : null;
            $duration = null;
            if ($started && $ended) {
                $duration = $started->diffInSeconds($ended);
            }
            if ($started) {
                DB::table('play_session_intervals')->insert([
                    'play_session_id' => $s->id,
                    'started_at' => $started,
                    'ended_at' => $ended,
                    'duration_seconds' => $duration,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('play_session_intervals');
    }
};











