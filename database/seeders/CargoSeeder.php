<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\models\Clients;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Clients::all();

        cargo::factory()->count(20)->make()->each(function ($cargo) use ($clients) {
            $cargo->client_id = $clients->random()->id; // Assign a random client to each cargo
            $cargo->save();
        });
    }
}
