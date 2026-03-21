<?php

namespace Database\Factories;

use App\Models\PlaySession;
use App\Models\PlaySessionInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaySessionIntervalFactory extends Factory
{
    protected $model = PlaySessionInterval::class;

    public function definition(): array
    {
        return [
            'play_session_id' => PlaySession::factory(),
            'started_at' => now()->subHour(),
            'ended_at' => null,
            'duration_seconds' => null,
        ];
    }
}
