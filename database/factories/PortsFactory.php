<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ports>
 */
class PortsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'name' => $this->faker->city . ' Port',
            'country' => $this->faker->country,
            'port_type' => $this->faker->randomElement(['Cargo', 'Passenger', 'Military', 'Fishing']),
            'coordinates' => $this->faker->latitude . ', ' . $this->faker->longitude,
            'depth' => $this->faker->randomFloat(2, 5, 50),
            'docking_capacity' => $this->faker->numberBetween(2, 20),
            'max_vessel_size' => $this->faker->randomFloat(2, 50, 300),
            'security_level' => $this->faker->randomElement(['High', 'Medium', 'Low']),
            'customs_authorized' => $this->faker->boolean(80),
            'operational_hours' => $this->faker->randomElement(['24/7', '6am-6pm', '8am-10pm']),
            'port_manager' => $this->faker->name,
            'port_contact_info' => $this->faker->phoneNumber,
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
