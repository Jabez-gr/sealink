<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Ships;
use App\Models\Ports;
use App\Models\Crew;
use App\Models\Clients;
use App\Models\Shipments;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ShipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = Cargo::where('is_active', true)->get();
        $ships = Ships::where('is_active', true)->get();
        $ports = Ports::where('is_active', true)->get();
        $crews = Crew::where('is_active', true)->get();
        $clients = Clients::where('is_active', true)->get();
        
        if ($cargos->isEmpty() || $ships->isEmpty() || $ports->isEmpty() || $crews->isEmpty() || $clients->isEmpty()) {
            Log::warning('One or more required models are empty. Skipping ShipmentsSeeder.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $originPort = Ports::inRandomOrder()->first();
            $destinationPort = Ports::inRandomOrder()
                ->where('id', '!=', $originPort->id)
                ->first();

            $departureDate = Carbon::now()->addDays(rand(1, 15));
            $arrivalEstimate = (clone $departureDate)->addDays(rand(5, 20));
            $actualArrival = rand(0, 1) ? (clone $arrivalEstimate)->addDays(rand(0, 5)) : null;

            $statusOptions = ['pending', 'in_transit', 'delivered', 'cancelled'];
            $status = $actualArrival ? 'delivered' : $statusOptions[array_rand($statusOptions)];

            Shipments::create([
                'ship_id'   => $ships->random()->id,
                'client_id' => $clients->random()->id,
                'cargo_id'  => $cargos->random()->id,
                'origin_port_id' => $originPort->id,
                'destination_port_id' => $destinationPort->id,
                'departure_date' => $departureDate,
                'arrival_estimate' => $arrivalEstimate,
                'actual_arrival_date' => $actualArrival,
                'status' => $status,
                'is_active' => true,
            ]);
        }

        Log::info('ShipmentsSeeder completed successfully.');  
        $this->command->info('ShipmentsSeeder completed successfully.');
    }
}
