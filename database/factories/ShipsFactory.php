<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Ships;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ships>
 */
class ShipsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word . ' Ship',
            'registration_number' => strtoupper($this->faker->unique()->bothify('???###')),
            'capacity_in_tonnes' => $this->faker->randomFloat(2, 100, 10000),
            'type' => $this->faker->randomElement([
                'cargo ship',
                'passenger ship',
                'military ship',
                'icebreaker',
                'fishing vessel',
                'barge ship'
            ]),
            'status' => $this->faker->randomElement(['active', 'under maintenance', 'decommissioned']),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
