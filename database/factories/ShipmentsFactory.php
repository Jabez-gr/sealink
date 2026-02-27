<?php

namespace Database\Factories;

use App\Models\Shipments;
use App\Models\Clients;
use App\Models\Cargo;
use App\Models\Ships;
use App\Models\Ports;
use App\Models\Crew;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipments>
 */
class ShipmentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departurePort = Ports::factory()->create();
        $arrivalPort = Ports::factory()->create();
        $ship = Ships::factory()->create();
        $cargo = Cargo::factory()->create();
        $crew = Crew::factory()->create();  
        $client = Clients::factory()->create(); 
         
        $departureDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $arrivalEstimatedDate = $this->faker->dateTimeBetween($departureDate, '+7 days');  
        $arrivalActualDate = $this->faker->boolean ? $this->faker->dateTimeBetween($arrivalEstimatedDate, '+2 days') : null;  

        $originPort = ports::inRandomOrder()->first();
        $destinationPort = ports::inRandomOrder()->where('id', '!=', $originPort->id)->first();  

        return [
            'cargo_id' => Cargo::inRandomOrder()->first()?->id,
            'ship_id' => Ships::inRandomOrder()->first()?->id,
            'origin_port_id' => $originPort?->id,
            'destination_port_id' => $destinationPort?->id,
            'departure_date' => $departureDate->format('Y-m-d'),
            'arrival_estimate' => $arrivalEstimatedDate->format('Y-m-d'),
            'actual_arrival_date' => $arrivalActualDate?->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pending', 'in_transit', 'delivered', 'delayed']),
            'is_active' => true,
        ];
    }
}
