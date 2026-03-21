<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\Guardian;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChildFactory extends Factory
{
    protected $model = Child::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'guardian_id' => Guardian::factory(),
            'name' => $this->faker->firstName(),
            'internal_code' => $this->faker->unique()->bothify('???###'),
            'birth_date' => $this->faker->dateTimeBetween('-10 years', '-1 year')->format('Y-m-d'),
        ];
    }
}
