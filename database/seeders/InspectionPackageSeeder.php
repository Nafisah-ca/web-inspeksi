<?php

namespace Database\Seeders;

use App\Models\InspectionPackage;
use Illuminate\Database\Seeder;

class InspectionPackageSeeder extends Seeder
{
    public function run(): void
    {
        InspectionPackage::create([
            'name'              => 'Inspeksi Dasar',
            'description'       => 'Pemeriksaan komponen utama kendaraan: mesin, rem, ban, dan lampu. Cocok untuk pengecekan rutin dan kendaraan bekas harga terjangkau.',
            'price'             => 150000,
            'duration_estimate' => 60,
            'is_active'         => true,
        ]);

        InspectionPackage::create([
            'name'              => 'Inspeksi Standar',
            'description'       => 'Pemeriksaan menyeluruh 20+ titik meliputi mesin, transmisi, kaki-kaki, kelistrikan, dan AC. Direkomendasikan untuk pembelian kendaraan bekas.',
            'price'             => 300000,
            'duration_estimate' => 120,
            'is_active'         => true,
        ]);

        InspectionPackage::create([
            'name'              => 'Inspeksi Komprehensif',
            'description'       => 'Inspeksi total 40+ titik termasuk body paint, kolong kendaraan, OBD scanner, test drive, dan laporan detail dengan foto. Terlengkap untuk ketenangan pikiran Anda.',
            'price'             => 550000,
            'duration_estimate' => 180,
            'is_active'         => true,
        ]);
    }
}
