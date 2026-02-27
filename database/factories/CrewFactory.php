<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crew>
 */
class CrewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ship_id' => null, // or \App\Models\Ship::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => $this->faker->randomElement([
                'Captain',
                'Chief Officer',
                'Able Seaman',
                'Ordinary Seaman',
                'Engine Cadet',
                'Radio Officer',
                'Chief Cook',
                'Steward',
                'Deckhand'
            ]),
            'phone_number' => $this->faker->phoneNumber(),
            'nationality' => $this->faker->country(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
