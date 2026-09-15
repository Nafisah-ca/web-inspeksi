<?php

namespace Database\Seeders;

use App\Models\InspectionChecklistItem;
use App\Models\InspectionPackage;
use Illuminate\Database\Seeder;

class InspectionChecklistItemSeeder extends Seeder
{
    public function run(): void
    {
        $basic    = InspectionPackage::where('name', 'Inspeksi Dasar')->first();
        $standard = InspectionPackage::where('name', 'Inspeksi Standar')->first();
        $comprehensive = InspectionPackage::where('name', 'Inspeksi Komprehensif')->first();

        // ── Paket Dasar ─────────────────────────────────────────
        $basicItems = [
            ['category' => 'Mesin',  'item_name' => 'Kondisi Mesin (Visual)', 'sort_order' => 1],
            ['category' => 'Mesin',  'item_name' => 'Level & Kualitas Oli Mesin', 'sort_order' => 2],
            ['category' => 'Mesin',  'item_name' => 'Level Air Radiator', 'sort_order' => 3],
            ['category' => 'Rem',    'item_name' => 'Kampas Rem Depan', 'sort_order' => 4],
            ['category' => 'Rem',    'item_name' => 'Kampas Rem Belakang', 'sort_order' => 5],
            ['category' => 'Ban',    'item_name' => 'Kondisi Ban Depan', 'sort_order' => 6],
            ['category' => 'Ban',    'item_name' => 'Kondisi Ban Belakang', 'sort_order' => 7],
            ['category' => 'Lampu', 'item_name' => 'Lampu Depan (Utama & Sein)', 'sort_order' => 8],
            ['category' => 'Lampu', 'item_name' => 'Lampu Belakang & Stop', 'sort_order' => 9],
        ];

        foreach ($basicItems as $item) {
            InspectionChecklistItem::create(array_merge($item, ['package_id' => $basic->id]));
        }

        // ── Paket Standar (semua item dasar + tambahan) ──────────
        $standardExtra = [
            ['category' => 'Mesin',       'item_name' => 'Kondisi Mesin (Visual)', 'sort_order' => 1],
            ['category' => 'Mesin',       'item_name' => 'Level & Kualitas Oli Mesin', 'sort_order' => 2],
            ['category' => 'Mesin',       'item_name' => 'Level Air Radiator', 'sort_order' => 3],
            ['category' => 'Mesin',       'item_name' => 'Kondisi Belt / Timing Belt', 'sort_order' => 4],
            ['category' => 'Mesin',       'item_name' => 'Kondisi Aki / Baterai', 'sort_order' => 5],
            ['category' => 'Transmisi',   'item_name' => 'Perpindahan Gigi (Manual/Otomatis)', 'sort_order' => 6],
            ['category' => 'Transmisi',   'item_name' => 'Level Oli Transmisi', 'sort_order' => 7],
            ['category' => 'Rem',         'item_name' => 'Kampas Rem Depan', 'sort_order' => 8],
            ['category' => 'Rem',         'item_name' => 'Kampas Rem Belakang', 'sort_order' => 9],
            ['category' => 'Rem',         'item_name' => 'Minyak Rem', 'sort_order' => 10],
            ['category' => 'Kaki-Kaki',   'item_name' => 'Kondisi Shock Absorber Depan', 'sort_order' => 11],
            ['category' => 'Kaki-Kaki',   'item_name' => 'Kondisi Shock Absorber Belakang', 'sort_order' => 12],
            ['category' => 'Kaki-Kaki',   'item_name' => 'Kondisi Tie Rod & Ball Joint', 'sort_order' => 13],
            ['category' => 'Ban',         'item_name' => 'Kondisi Ban Depan', 'sort_order' => 14],
            ['category' => 'Ban',         'item_name' => 'Kondisi Ban Belakang', 'sort_order' => 15],
            ['category' => 'Ban',         'item_name' => 'Tekanan Angin Ban', 'sort_order' => 16],
            ['category' => 'Kelistrikan', 'item_name' => 'Sistem Pengisian (Alternator)', 'sort_order' => 17],
            ['category' => 'Kelistrikan', 'item_name' => 'Lampu Depan & Belakang', 'sort_order' => 18],
            ['category' => 'AC',          'item_name' => 'Kinerja AC (Pendinginan)', 'sort_order' => 19],
            ['category' => 'AC',          'item_name' => 'Kondisi Blower & Filter Kabin', 'sort_order' => 20],
        ];

        foreach ($standardExtra as $item) {
            InspectionChecklistItem::create(array_merge($item, ['package_id' => $standard->id]));
        }

        // ── Paket Komprehensif (semua standar + tambahan) ────────
        $compItems = array_merge($standardExtra, [
            ['category' => 'Body & Cat',  'item_name' => 'Kondisi Cat Body (Visual & Thickness)', 'sort_order' => 21],
            ['category' => 'Body & Cat',  'item_name' => 'Kondisi Kaca Depan & Belakang', 'sort_order' => 22],
            ['category' => 'Body & Cat',  'item_name' => 'Kondisi Pintu & Engsel', 'sort_order' => 23],
            ['category' => 'Body & Cat',  'item_name' => 'Kondisi Atap & Sunroof (jika ada)', 'sort_order' => 24],
            ['category' => 'Kolong',      'item_name' => 'Kondisi Rangka / Chasis', 'sort_order' => 25],
            ['category' => 'Kolong',      'item_name' => 'Kondisi Knalpot & Pipa Gas Buang', 'sort_order' => 26],
            ['category' => 'Kolong',      'item_name' => 'Kebocoran Oli / Cairan', 'sort_order' => 27],
            ['category' => 'Interior',    'item_name' => 'Kondisi Dashboard & Panel Instrumen', 'sort_order' => 28],
            ['category' => 'Interior',    'item_name' => 'Sistem Audio & Infotainment', 'sort_order' => 29],
            ['category' => 'Interior',    'item_name' => 'Kondisi Jok & Sabuk Pengaman', 'sort_order' => 30],
            ['category' => 'Diagnostik',  'item_name' => 'Scan OBD-II (Error Code)', 'sort_order' => 31],
            ['category' => 'Diagnostik',  'item_name' => 'Test Drive (10-15 Menit)', 'sort_order' => 32],
        ]);

        foreach ($compItems as $item) {
            $sortOrder = $item['sort_order'];
            InspectionChecklistItem::create(array_merge(
                ['package_id' => $comprehensive->id],
                ['category' => $item['category'], 'item_name' => $item['item_name'], 'sort_order' => $sortOrder]
            ));
        }
    }
}
