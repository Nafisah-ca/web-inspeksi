<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [

            // ─────────────────────────────────────────
            // HERO
            // ─────────────────────────────────────────
            [
                'section'    => 'hero',
                'key'        => 'badge',
                'label'      => 'Badge / Label Kecil di Atas Judul',
                'type'       => 'text',
                'value'      => 'Dipercaya 1.000+ Pelanggan',
                'sort_order' => 1,
            ],
            [
                'section'    => 'hero',
                'key'        => 'title_line1',
                'label'      => 'Judul Baris 1',
                'type'       => 'text',
                'value'      => 'Inspeksi Kendaraan',
                'sort_order' => 2,
            ],
            [
                'section'    => 'hero',
                'key'        => 'title_line2',
                'label'      => 'Judul Baris 2 (berwarna)',
                'type'       => 'text',
                'value'      => 'Profesional & Transparan',
                'sort_order' => 3,
            ],
            [
                'section'    => 'hero',
                'key'        => 'subtitle',
                'label'      => 'Deskripsi / Subtitle',
                'type'       => 'textarea',
                'value'      => 'Ketahui kondisi kendaraan Anda sebelum membeli atau menjual. Tim inspektor bersertifikat kami siap memberikan laporan detail yang bisa Anda percaya.',
                'sort_order' => 4,
            ],
            [
                'section'    => 'hero',
                'key'        => 'btn_primary',
                'label'      => 'Teks Tombol Utama',
                'type'       => 'text',
                'value'      => 'Booking Sekarang',
                'sort_order' => 5,
            ],
            [
                'section'    => 'hero',
                'key'        => 'btn_secondary',
                'label'      => 'Teks Tombol Kedua',
                'type'       => 'text',
                'value'      => 'Lihat Paket',
                'sort_order' => 6,
            ],

            // ─────────────────────────────────────────
            // STATS
            // ─────────────────────────────────────────
            [
                'section'    => 'stats',
                'key'        => 'stat1_value',
                'label'      => 'Statistik 1 — Angka',
                'type'       => 'text',
                'value'      => '0',
                'sort_order' => 1,
            ],
            [
                'section'    => 'stats',
                'key'        => 'stat1_label',
                'label'      => 'Statistik 1 — Label',
                'type'       => 'text',
                'value'      => 'Inspeksi Selesai',
                'sort_order' => 2,
            ],
            [
                'section'    => 'stats',
                'key'        => 'stat2_value',
                'label'      => 'Statistik 2 — Angka',
                'type'       => 'text',
                'value'      => '100%',
                'sort_order' => 3,
            ],
            [
                'section'    => 'stats',
                'key'        => 'stat2_label',
                'label'      => 'Statistik 2 — Label',
                'type'       => 'text',
                'value'      => 'Kepuasan Pelanggan',
                'sort_order' => 4,
            ],
            [
                'section'    => 'stats',
                'key'        => 'stat3_value',
                'label'      => 'Statistik 3 — Angka',
                'type'       => 'text',
                'value'      => '2',
                'sort_order' => 5,
            ],
            [
                'section'    => 'stats',
                'key'        => 'stat3_label',
                'label'      => 'Statistik 3 — Label',
                'type'       => 'text',
                'value'      => 'Inspektor Terlatih',
                'sort_order' => 6,
            ],
            [
                'section'    => 'stats',
                'key'        => 'stat4_value',
                'label'      => 'Statistik 4 — Angka',
                'type'       => 'text',
                'value'      => '3',
                'sort_order' => 7,
            ],
            [
                'section'    => 'stats',
                'key'        => 'stat4_label',
                'label'      => 'Statistik 4 — Label',
                'type'       => 'text',
                'value'      => 'Paket Tersedia',
                'sort_order' => 8,
            ],

            // ─────────────────────────────────────────
            // WHY US (Keunggulan)
            // ─────────────────────────────────────────
            [
                'section'    => 'why_us',
                'key'        => 'title',
                'label'      => 'Judul Section',
                'type'       => 'text',
                'value'      => 'Garansi & Komitmen Kami',
                'sort_order' => 1,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item1_icon',
                'label'      => 'Keunggulan 1 — Ikon (emoji)',
                'type'       => 'text',
                'value'      => '🔍',
                'sort_order' => 2,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item1_title',
                'label'      => 'Keunggulan 1 — Judul',
                'type'       => 'text',
                'value'      => 'Inspeksi Menyeluruh',
                'sort_order' => 3,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item1_desc',
                'label'      => 'Keunggulan 1 — Deskripsi',
                'type'       => 'textarea',
                'value'      => 'Setiap titik diperiksa dengan teliti menggunakan alat profesional.',
                'sort_order' => 4,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item2_icon',
                'label'      => 'Keunggulan 2 — Ikon (emoji)',
                'type'       => 'text',
                'value'      => '📝',
                'sort_order' => 5,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item2_title',
                'label'      => 'Keunggulan 2 — Judul',
                'type'       => 'text',
                'value'      => 'Laporan Transparan',
                'sort_order' => 6,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item2_desc',
                'label'      => 'Keunggulan 2 — Deskripsi',
                'type'       => 'textarea',
                'value'      => 'Laporan lengkap dengan foto, status setiap komponen, dan rekomendasi perbaikan.',
                'sort_order' => 7,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item3_icon',
                'label'      => 'Keunggulan 3 — Ikon (emoji)',
                'type'       => 'text',
                'value'      => '💯',
                'sort_order' => 8,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item3_title',
                'label'      => 'Keunggulan 3 — Judul',
                'type'       => 'text',
                'value'      => 'Garansi Kepuasan',
                'sort_order' => 9,
            ],
            [
                'section'    => 'why_us',
                'key'        => 'item3_desc',
                'label'      => 'Keunggulan 3 — Deskripsi',
                'type'       => 'textarea',
                'value'      => 'Tidak puas? Kami refund 100% jika laporan terbukti tidak akurat.',
                'sort_order' => 10,
            ],

            // ─────────────────────────────────────────
            // HOW (Cara Kerja)
            // ─────────────────────────────────────────
            [
                'section'    => 'how',
                'key'        => 'title',
                'label'      => 'Judul Section',
                'type'       => 'text',
                'value'      => 'Cara Kerja',
                'sort_order' => 1,
            ],
            [
                'section'    => 'how',
                'key'        => 'subtitle',
                'label'      => 'Subtitle Section',
                'type'       => 'text',
                'value'      => 'Proses inspeksi yang mudah dalam 4 langkah',
                'sort_order' => 2,
            ],
            [
                'section'    => 'how',
                'key'        => 'step1_title',
                'label'      => 'Langkah 1 — Judul',
                'type'       => 'text',
                'value'      => 'Pilih Paket',
                'sort_order' => 3,
            ],
            [
                'section'    => 'how',
                'key'        => 'step1_desc',
                'label'      => 'Langkah 1 — Deskripsi',
                'type'       => 'textarea',
                'value'      => 'Tentukan paket inspeksi sesuai kebutuhan Anda.',
                'sort_order' => 4,
            ],
            [
                'section'    => 'how',
                'key'        => 'step2_title',
                'label'      => 'Langkah 2 — Judul',
                'type'       => 'text',
                'value'      => 'Booking Jadwal',
                'sort_order' => 5,
            ],
            [
                'section'    => 'how',
                'key'        => 'step2_desc',
                'label'      => 'Langkah 2 — Deskripsi',
                'type'       => 'textarea',
                'value'      => 'Isi data kendaraan dan pilih tanggal serta waktu yang tersedia.',
                'sort_order' => 6,
            ],
            [
                'section'    => 'how',
                'key'        => 'step3_title',
                'label'      => 'Langkah 3 — Judul',
                'type'       => 'text',
                'value'      => 'Inspeksi Dilakukan',
                'sort_order' => 7,
            ],
            [
                'section'    => 'how',
                'key'        => 'step3_desc',
                'label'      => 'Langkah 3 — Deskripsi',
                'type'       => 'textarea',
                'value'      => 'Inspektor kami datang dan melakukan pengecekan menyeluruh.',
                'sort_order' => 8,
            ],
            [
                'section'    => 'how',
                'key'        => 'step4_title',
                'label'      => 'Langkah 4 — Judul',
                'type'       => 'text',
                'value'      => 'Terima Laporan',
                'sort_order' => 9,
            ],
            [
                'section'    => 'how',
                'key'        => 'step4_desc',
                'label'      => 'Langkah 4 — Deskripsi',
                'type'       => 'textarea',
                'value'      => 'Dapatkan laporan lengkap dengan foto dan rekomendasi perbaikan.',
                'sort_order' => 10,
            ],

            // ─────────────────────────────────────────
            // CTA
            // ─────────────────────────────────────────
            [
                'section'    => 'cta',
                'key'        => 'title',
                'label'      => 'Judul CTA',
                'type'       => 'text',
                'value'      => 'Siap Inspeksi Kendaraan Anda?',
                'sort_order' => 1,
            ],
            [
                'section'    => 'cta',
                'key'        => 'subtitle',
                'label'      => 'Deskripsi CTA',
                'type'       => 'textarea',
                'value'      => 'Jangan biarkan masalah tersembunyi merogoh kantong Anda. Inspeksi sekarang, tenang berkendara!',
                'sort_order' => 2,
            ],
            [
                'section'    => 'cta',
                'key'        => 'btn_text',
                'label'      => 'Teks Tombol CTA',
                'type'       => 'text',
                'value'      => 'Booking Sekarang',
                'sort_order' => 3,
            ],

            // ─────────────────────────────────────────
            // CONTACT
            // ─────────────────────────────────────────
            [
                'section'    => 'contact',
                'key'        => 'phone',
                'label'      => 'Nomor Telepon / WhatsApp',
                'type'       => 'text',
                'value'      => '0812-0000-0001',
                'sort_order' => 1,
            ],
            [
                'section'    => 'contact',
                'key'        => 'email',
                'label'      => 'Alamat Email',
                'type'       => 'text',
                'value'      => 'info@inspeksiku.id',
                'sort_order' => 2,
            ],
            [
                'section'    => 'contact',
                'key'        => 'address',
                'label'      => 'Alamat Lengkap',
                'type'       => 'textarea',
                'value'      => 'Jakarta, Indonesia',
                'sort_order' => 3,
            ],
            [
                'section'    => 'contact',
                'key'        => 'open_hours',
                'label'      => 'Jam Operasional',
                'type'       => 'text',
                'value'      => 'Senin–Sabtu, 08.00–17.00 WIB',
                'sort_order' => 4,
            ],
            [
                'section'    => 'contact',
                'key'        => 'whatsapp_number',
                'label'      => 'Nomor WhatsApp (tanpa +, contoh: 6281200000001)',
                'type'       => 'text',
                'value'      => '6281200000001',
                'sort_order' => 5,
            ],

            // ─────────────────────────────────────────
            // FOOTER
            // ─────────────────────────────────────────
            [
                'section'    => 'footer',
                'key'        => 'brand_name',
                'label'      => 'Nama Brand / Logo Teks',
                'type'       => 'text',
                'value'      => 'InspeksiKu',
                'sort_order' => 1,
            ],
            [
                'section'    => 'footer',
                'key'        => 'tagline',
                'label'      => 'Tagline Footer',
                'type'       => 'textarea',
                'value'      => 'Platform inspeksi kendaraan terpercaya. Cepat, transparan, dan profesional.',
                'sort_order' => 2,
            ],
            [
                'section'    => 'footer',
                'key'        => 'copyright',
                'label'      => 'Teks Copyright (tahun otomatis)',
                'type'       => 'text',
                'value'      => 'InspeksiKu. Dibuat dengan ❤️ di Indonesia.',
                'sort_order' => 3,
            ],
        ];

        foreach ($contents as $item) {
            SiteContent::updateOrCreate(
                ['section' => $item['section'], 'key' => $item['key']],
                $item
            );
        }
    }
}
