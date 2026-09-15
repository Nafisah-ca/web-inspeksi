<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $andi = User::where('email', 'andi@example.com')->first();
        $siti = User::where('email', 'siti@example.com')->first();
        $reza = User::where('email', 'reza@example.com')->first();

        Vehicle::create([
            'user_id'      => $andi->id,
            'brand'        => 'Toyota',
            'model'        => 'Avanza',
            'plate_number' => 'B 1234 ABC',
            'year'         => 2019,
            'type'         => 'mpv',
        ]);

        Vehicle::create([
            'user_id'      => $andi->id,
            'brand'        => 'Honda',
            'model'        => 'Civic',
            'plate_number' => 'B 5678 DEF',
            'year'         => 2021,
            'type'         => 'sedan',
        ]);

        Vehicle::create([
            'user_id'      => $siti->id,
            'brand'        => 'Mitsubishi',
            'model'        => 'Xpander',
            'plate_number' => 'D 9999 XYZ',
            'year'         => 2020,
            'type'         => 'mpv',
        ]);

        Vehicle::create([
            'user_id'      => $reza->id,
            'brand'        => 'Suzuki',
            'model'        => 'Ertiga',
            'plate_number' => 'F 4321 GHI',
            'year'         => 2018,
            'type'         => 'mpv',
        ]);
    }
}
