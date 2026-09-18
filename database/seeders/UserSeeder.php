<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin utama
        User::create([
            'name'              => 'Admin InspeksiKu',
            'email'             => 'admin@inspeksiku.id',
            'phone'             => '081200000001',
            'password'          => Hash::make('admin123'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        // Inspektor 1
        User::create([
            'name'              => 'Budi Santoso',
            'email'             => 'budi@inspeksiku.id',
            'phone'             => '081200000002',
            'password'          => Hash::make('inspektor123'),
            'role'              => 'inspector',
            'email_verified_at' => now(),
        ]);

        // Inspektor 2
        User::create([
            'name'              => 'Agus Prasetyo',
            'email'             => 'agus@inspeksiku.id',
            'phone'             => '081200000003',
            'password'          => Hash::make('inspektor123'),
            'role'              => 'inspector',
            'email_verified_at' => now(),
        ]);
    }
}
