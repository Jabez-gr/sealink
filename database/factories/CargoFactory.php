<?php

namespace Database\Factories;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cargo>
 */
class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(),
            'weight' => $this->faker->randomFloat(2, 1, 1000), // Random weight between 1 and 1000
            'volume' => $this->faker->randomFloat(2, 0.1, 100), // Random volume between 0.1 and 100
            'client_id' => \App\Models\Clients::factory(), // Assuming you have a Clients model and factory
            'cargo_type' => $this->faker->randomElement(['perishable', 'dangerous', 'general', 'other']),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
