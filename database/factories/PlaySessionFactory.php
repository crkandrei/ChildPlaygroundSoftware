<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\PlaySession;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaySessionFactory extends Factory
{
    protected $model = PlaySession::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'child_id' => Child::factory(),
            'started_at' => now()->subHour(),
            'ended_at' => null,
            'calculated_price' => null,
            'is_birthday' => false,
            'is_jungle' => false,
            'paid_at' => null,
            'payment_method' => null,
            'payment_status' => null,
            'voucher_hours' => null,
        ];
    }
}
