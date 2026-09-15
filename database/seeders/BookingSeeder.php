<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\InspectionPackage;
use App\Models\InspectionResult;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $andi     = User::where('email', 'andi@example.com')->first();
        $siti     = User::where('email', 'siti@example.com')->first();
        $reza     = User::where('email', 'reza@example.com')->first();
        $budi     = User::where('email', 'budi@inspeksi.test')->first();
        $agus     = User::where('email', 'agus@inspeksi.test')->first();

        $basic        = InspectionPackage::where('name', 'Inspeksi Dasar')->first();
        $standard     = InspectionPackage::where('name', 'Inspeksi Standar')->first();
        $comprehensive= InspectionPackage::where('name', 'Inspeksi Komprehensif')->first();

        $andiCar1 = Vehicle::where('user_id', $andi->id)->where('model', 'Avanza')->first();
        $andiCar2 = Vehicle::where('user_id', $andi->id)->where('model', 'Civic')->first();
        $sitiCar  = Vehicle::where('user_id', $siti->id)->first();
        $rezaCar  = Vehicle::where('user_id', $reza->id)->first();

        // 1. Pending – baru dibuat customer
        Booking::create([
            'booking_code'  => 'INS-PEND0001',
            'user_id'       => $reza->id,
            'vehicle_id'    => $rezaCar->id,
            'package_id'    => $basic->id,
            'inspector_id'  => null,
            'booking_date'  => now()->addDays(3)->toDateString(),
            'booking_time'  => '09:00:00',
            'status'        => 'pending',
            'notes'         => 'Mohon dicek bagian mesin, terasa kurang bertenaga.',
        ]);

        // 2. Confirmed – sudah dikonfirmasi admin, inspektor sudah di-assign
        Booking::create([
            'booking_code'  => 'INS-CONF0002',
            'user_id'       => $siti->id,
            'vehicle_id'    => $sitiCar->id,
            'package_id'    => $standard->id,
            'inspector_id'  => $agus->id,
            'booking_date'  => now()->addDays(1)->toDateString(),
            'booking_time'  => '10:00:00',
            'status'        => 'confirmed',
            'notes'         => 'Kendaraan akan dibeli bekas, tolong cek menyeluruh.',
        ]);

        // 3. On Progress – sedang dikerjakan
        $onProgressBooking = Booking::create([
            'booking_code'  => 'INS-PROG0003',
            'user_id'       => $andi->id,
            'vehicle_id'    => $andiCar1->id,
            'package_id'    => $standard->id,
            'inspector_id'  => $budi->id,
            'booking_date'  => now()->toDateString(),
            'booking_time'  => '08:00:00',
            'status'        => 'on_progress',
            'notes'         => 'Service rutin tahunan.',
        ]);

        // 4. Completed – sudah selesai dengan hasil inspeksi
        $completedBooking = Booking::create([
            'booking_code'  => 'INS-DONE0004',
            'user_id'       => $andi->id,
            'vehicle_id'    => $andiCar2->id,
            'package_id'    => $comprehensive->id,
            'inspector_id'  => $budi->id,
            'booking_date'  => now()->subDays(5)->toDateString(),
            'booking_time'  => '13:00:00',
            'status'        => 'completed',
            'notes'         => 'Pengecekan sebelum jual.',
        ]);

        InspectionResult::create([
            'booking_id'        => $completedBooking->id,
            'checklist_json'    => [
                ['item_name' => 'Kondisi Mesin (Visual)',           'category' => 'Mesin',        'status' => 'ok',      'note' => 'Bersih, tidak ada kebocoran'],
                ['item_name' => 'Level & Kualitas Oli Mesin',       'category' => 'Mesin',        'status' => 'warning', 'note' => 'Oli sudah agak gelap, segera ganti'],
                ['item_name' => 'Level Air Radiator',               'category' => 'Mesin',        'status' => 'ok',      'note' => 'Normal'],
                ['item_name' => 'Kondisi Belt / Timing Belt',       'category' => 'Mesin',        'status' => 'ok',      'note' => 'Masih baik'],
                ['item_name' => 'Kondisi Aki / Baterai',            'category' => 'Mesin',        'status' => 'ok',      'note' => 'Tegangan 12.8V, normal'],
                ['item_name' => 'Kampas Rem Depan',                 'category' => 'Rem',          'status' => 'warning', 'note' => 'Ketebalan ~3mm, disarankan ganti dalam 5.000 km'],
                ['item_name' => 'Kampas Rem Belakang',              'category' => 'Rem',          'status' => 'ok',      'note' => 'Masih tebal'],
                ['item_name' => 'Kondisi Ban Depan',                'category' => 'Ban',          'status' => 'ok',      'note' => 'TWI masih aman'],
                ['item_name' => 'Kondisi Ban Belakang',             'category' => 'Ban',          'status' => 'ok',      'note' => 'TWI masih aman'],
                ['item_name' => 'Kondisi Cat Body',                 'category' => 'Body & Cat',   'status' => 'ok',      'note' => 'Tebal cat normal, tidak ada bekas tabrakan'],
                ['item_name' => 'Scan OBD-II (Error Code)',         'category' => 'Diagnostik',   'status' => 'ok',      'note' => 'Tidak ada DTC tersimpan'],
                ['item_name' => 'Test Drive',                       'category' => 'Diagnostik',   'status' => 'ok',      'note' => 'Akselerasi normal, tidak ada getaran aneh'],
            ],
            'condition_summary' => 'Kendaraan secara keseluruhan dalam kondisi BAIK. Terdapat 2 item yang perlu perhatian: kualitas oli mesin dan ketebalan kampas rem depan yang mulai menipis.',
            'recommendation'    => "1. Ganti oli mesin segera (rekomendasi oli 10W-40 API SN).\n2. Monitor kampas rem depan, ganti sebelum mencapai 5.000 km ke depan.\n3. Lakukan perawatan rutin setiap 10.000 km.",
            'photos'            => [],
            'inspector_notes'   => 'Secara keseluruhan kendaraan terawat. Layak jual dengan harga normal.',
            'completed_at'      => now()->subDays(5)->setTime(15, 30),
        ]);

        // 5. Cancelled
        Booking::create([
            'booking_code'       => 'INS-CANC0005',
            'user_id'            => $siti->id,
            'vehicle_id'         => $sitiCar->id,
            'package_id'         => $basic->id,
            'inspector_id'       => null,
            'booking_date'       => now()->subDays(2)->toDateString(),
            'booking_time'       => '11:00:00',
            'status'             => 'cancelled',
            'notes'              => 'Pengecekan rutin.',
            'cancellation_reason'=> 'Customer membatalkan karena ada keperluan mendadak.',
        ]);
    }
}
