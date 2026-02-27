<?php

namespace Database\Seeders;

use App\Models\Ports;
use App\Models\Shipments;
use App\Models\Ships;
use App\Models\User;
use App\Models\Clients;
use App\Models\Cargo;
use App\Models\Crew;
use Database\Seeders\ClientsSeeder;
use Database\Seeders\CargoSeeder;
use Database\Seeders\CrewSeeder;
use Database\Seeders\PortsSeeder;
use Database\Seeders\ShipsSeeder;
use Database\Seeders\ShipmentsSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            ClientsSeeder::class,
            CargoSeeder::class,
            CrewSeeder::class,
            PortsSeeder::class,
            ShipsSeeder::class,
            ShipmentsSeeder::class,
        ]);

      

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
