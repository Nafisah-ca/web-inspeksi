<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,               // admin + 2 inspektor saja
            InspectionPackageSeeder::class,  // 3 paket inspeksi
            InspectionChecklistItemSeeder::class, // item checklist per paket
            SiteContentSeeder::class,        // konten landing page (bisa diedit via CMS)
        ]);
    }
}
