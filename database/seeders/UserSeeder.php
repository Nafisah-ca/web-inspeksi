<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Utama',
            'email'    => 'admin@inspeksi.test',
            'phone'    => '081200000001',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'email_verified_at' => now(),
        ]);

        // Inspectors
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@inspeksi.test',
            'phone'    => '081200000002',
            'password' => Hash::make('password'),
            'role'     => 'inspector',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'     => 'Agus Prasetyo',
            'email'    => 'agus@inspeksi.test',
            'phone'    => '081200000003',
            'password' => Hash::make('password'),
            'role'     => 'inspector',
            'email_verified_at' => now(),
        ]);

        // Customers
        User::create([
            'name'     => 'Andi Wijaya',
            'email'    => 'andi@example.com',
            'phone'    => '081300000001',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@example.com',
            'phone'    => '081300000002',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'     => 'Reza Firmansyah',
            'email'    => 'reza@example.com',
            'phone'    => '081300000003',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
