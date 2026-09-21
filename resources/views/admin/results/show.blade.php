@extends('layouts.admin')
@section('title', 'Laporan Inspeksi — ' . $booking->booking_code)
@section('page-title', 'Laporan Hasil Inspeksi')
@section('breadcrumb')
    <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-700">Semua Booking</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.bookings.show', $booking) }}" class="hover:text-gray-700">{{ $booking->booking_code }}</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-gray-900">Laporan Inspeksi</span>
@endsection

@push('styles')
<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
        header, aside, nav { display: none !important; }
        main { padding: 0 !important; }
    }
</style>
@endpush

@section('content')
{{-- Toolbar --}}
<div class="flex items-center justify-between mb-5 flex-wrap gap-3 no-print">
    <a href="{{ route('admin.bookings.show', $booking) }}"
       class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Booking
    </a>
    <div class="flex gap-2">
        <button onclick="window.print()"
                class="flex items-center gap-2 btn-secondary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak Laporan
        </button>
    </div>
</div>

{{-- ============================================================
     LAPORAN — Desain bergaya dokumen inspeksi profesional
     ============================================================ --}}
<div class="max-w-4xl mx-auto space-y-5" id="laporan">

    {{-- === HEADER LAPORAN === --}}
    <div class="card overflow-hidden">
        {{-- Banner merah atas --}}
        <div class="bg-red-600 px-6 py-3 flex items-center justify-between">
            <div>
                <p class="text-white font-bold text-lg tracking-wide">LAPORAN PENGECEKAN KENDARAAN</p>
                <p class="text-red-200 text-xs">{{ config('app.name', 'InspeksiKu') }}</p>
            </div>
            <div class="text-right">
                <p class="text-white text-xs font-mono">{{ $booking->booking_code }}</p>
                <p class="text-red-200 text-xs">{{ $result->completed_at?->format('d M Y') ?? now()->format('d M Y') }}</p>
            </div>
        </div>

        {{-- Info kendaraan --}}
        <div class="p-5 grid sm:grid-cols-2 gap-x-8 gap-y-3 text-sm">
            @foreach([
                ['Merk',           $booking->vehicle->brand],
                ['Model',          $booking->vehicle->model],
                ['No. Polisi',     $booking->vehicle->plate_number],
                ['Nama Customer',  $booking->user->name],
                ['Tgl Pengecekan', $result->completed_at?->translatedFormat('d F Y') ?? '-'],
                ['Tahun Mobil',    $booking->vehicle->year],
                ['Kilometer',      $kilometer ? number_format($kilometer) . ' km' : '-'],
                ['Inspektor',      $booking->inspector?->name ?? '-'],
            ] as [$lbl, $val])
            <div class="flex gap-2">
                <span class="text-gray-400 w-36 shrink-0">{{ $lbl }}</span>
                <span class="font-semibold text-gray-900">: {{ $val }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- === SUMMARY CARD UTAMA === --}}
    @php
        $statusIcons = [
            'ok'      => ['bg-green-500',  '✓', 'Baik'],
            'warning' => ['bg-yellow-400', '⚙', 'Perlu Servis'],
            'bad'     => ['bg-red-500',    '✕', 'Ganti'],
        ];
        $systems = [
            'mesin'     => 'MESIN',
            'suspensi'  => 'SUSPENSI',
            'transmisi' => 'TRANSMISI',
            'ac'        => 'AC',
        ];
    @endphp
    <div class="card p-5">
        <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Kondisi Sistem Utama</h3>
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
            {{-- Sistem 4 --}}
            @foreach($systems as $key => $label)
            @php
                $st  = $summaryCard[$key] ?? 'ok';
                [$bg, $icon, $txt] = $statusIcons[$st] ?? ['bg-gray-300','?','N/A'];
            @endphp
            <div class="flex flex-col items-center gap-1">
                <div class="w-12 h-12 {{ $bg }} rounded-full flex items-center justify-center text-white text-xl font-bold shadow">
                    {{ $icon }}
                </div>
                <span class="text-xs font-bold text-gray-700 text-center leading-tight">{{ $label }}</span>
                <span class="text-xs text-gray-400">{{ $txt }}</span>
            </div>
            @endforeach

            {{-- Bebas Banjir --}}
            <div class="flex flex-col items-center gap-1">
                <div class="w-12 h-12 {{ $summaryCard['bebas_banjir'] ? 'bg-green-500' : 'bg-red-500' }} rounded-full flex items-center justify-center text-white text-xl font-bold shadow">
                    {{ $summaryCard['bebas_banjir'] ? '✓' : '✕' }}
                </div>
                <span class="text-xs font-bold text-gray-700 text-center leading-tight">BEBAS BANJIR</span>
                <span class="text-xs text-gray-400">{{ $summaryCard['bebas_banjir'] ? 'Ya' : 'Tidak' }}</span>
            </div>

            {{-- Bebas Tabrakan --}}
            <div class="flex flex-col items-center gap-1">
                <div class="w-12 h-12 {{ $summaryCard['bebas_tabrakan'] ? 'bg-green-500' : 'bg-red-500' }} rounded-full flex items-center justify-center text-white text-xl font-bold shadow">
                    {{ $summaryCard['bebas_tabrakan'] ? '✓' : '✕' }}
                </div>
                <span class="text-xs font-bold text-gray-700 text-center leading-tight">BEBAS TABRAKAN</span>
                <span class="text-xs text-gray-400">{{ $summaryCard['bebas_tabrakan'] ? 'Ya' : 'Tidak' }}</span>
            </div>
        </div>

        {{-- Legenda --}}
        <div class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-gray-100 text-xs">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span><span class="text-gray-600">Baik</span></span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span><span class="text-gray-600">Perlu Diservis</span></span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span><span class="text-gray-600">Perlu Diganti</span></span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-gray-300 inline-block"></span><span class="text-gray-600">Tidak Tersedia</span></span>
        </div>
    </div>

    {{-- === STATISTIK CHECKLIST === --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="card p-4 text-center bg-green-50 border border-green-100">
            <p class="text-3xl font-bold text-green-600">{{ $result->ok_count }}</p>
            <p class="text-xs font-semibold text-green-600 mt-1">BAIK / OK</p>
        </div>
        <div class="card p-4 text-center bg-yellow-50 border border-yellow-100">
            <p class="text-3xl font-bold text-yellow-600">{{ $result->warning_count }}</p>
            <p class="text-xs font-semibold text-yellow-600 mt-1">PERLU SERVIS</p>
        </div>
        <div class="card p-4 text-center bg-red-50 border border-red-100">
            <p class="text-3xl font-bold text-red-600">{{ $result->bad_count }}</p>
            <p class="text-xs font-semibold text-red-600 mt-1">PERLU DIGANTI</p>
        </div>
    </div>

    {{-- === DETAIL CHECKLIST PER KATEGORI === --}}
    @if($checklistByCategory->isNotEmpty())
    <div class="card overflow-hidden">
        <div class="px-5 py-3 bg-gray-800 flex items-center">
            <h3 class="font-bold text-white text-sm uppercase tracking-wide">Catatan Montir / Hasil Checklist</h3>
        </div>
        @foreach($checklistByCategory as $category => $items)
        <div>
            <div class="px-5 py-2 bg-gray-100 border-b border-t border-gray-200">
                <p class="text-xs font-bold text-gray-600 uppercase tracking-wider">{{ $category }}</p>
            </div>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-50">
                    @foreach($items as $item)
                    @php
                        $st = $item['status'] ?? 'ok';
                        $rowBg = match($st) {
                            'warning' => 'bg-yellow-50',
                            'bad'     => 'bg-red-50',
                            'na'      => 'bg-gray-50',
                            default   => 'bg-white',
                        };
                        $badge = match($st) {
                            'ok'      => ['bg-green-100 text-green-700',  'Baik'],
                            'warning' => ['bg-yellow-100 text-yellow-700','Perlu Diservis'],
                            'bad'     => ['bg-red-100 text-red-700',      'Perlu Diganti'],
                            'na'      => ['bg-gray-100 text-gray-500',    'N/A'],
                            default   => ['bg-gray-100 text-gray-500',    $st],
                        };
                    @endphp
                    <tr class="{{ $rowBg }}">
                        <td class="px-5 py-2.5 font-medium text-gray-800 w-1/2">{{ $item['item_name'] }}</td>
                        <td class="px-3 py-2.5">
                            <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full {{ $badge[0] }}">
                                {{ $badge[1] }}
                            </span>
                        </td>
                        <td class="px-3 py-2.5 text-gray-500 text-xs italic">
                            {{ $item['note'] ?? '' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

        {{-- Catatan Tambahan --}}
        @if(trim($inspectorNotes))
        <div class="border-t border-gray-200">
            <div class="px-5 py-2 bg-gray-100 border-b border-gray-200">
                <p class="text-xs font-bold text-gray-600 uppercase tracking-wider">Lain-lain</p>
            </div>
            <div class="px-5 py-4 text-sm text-gray-700 bg-white">
                @foreach(array_filter(array_map('trim', explode("\n", $inspectorNotes))) as $line)
                <p class="mb-1">{{ $line }}</p>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- === RINGKASAN & REKOMENDASI === --}}
    <div class="grid sm:grid-cols-2 gap-5">
        <div class="card p-5">
            <h3 class="font-bold text-gray-900 text-sm mb-2">Ringkasan Kondisi</h3>
            <p class="text-sm text-gray-700 leading-relaxed">{{ $result->condition_summary }}</p>
        </div>
        <div class="card p-5 bg-blue-50 border border-blue-100">
            <h3 class="font-bold text-blue-900 text-sm mb-2">Rekomendasi</h3>
            <p class="text-sm text-blue-800 leading-relaxed">{{ $result->recommendation }}</p>
        </div>
    </div>

    {{-- === TANDA TANGAN === --}}
    <div class="card overflow-hidden">
        <div class="bg-red-600 px-5 py-2">
            <p class="text-white font-bold text-sm">TANDA TANGAN</p>
        </div>
        <div class="p-5">
            <p class="text-xs text-gray-500 mb-1">Inspeksi sudah dicek dengan baik dan benar</p>
            <p class="text-xs text-gray-500 mb-6">Tanggal: {{ $result->completed_at?->format('d F Y') ?? now()->format('d F Y') }}</p>
            <div class="grid grid-cols-2 gap-8 text-sm">
                <div>
                    <div class="h-16 border-b border-gray-300 mb-1"></div>
                    <p class="font-semibold text-gray-800">{{ $booking->inspector?->name ?? '—' }}</p>
                    <p class="text-xs text-gray-400">Tanda Tangan Inspektor</p>
                </div>
                <div>
                    <div class="h-16 border-b border-gray-300 mb-1"></div>
                    <p class="font-semibold text-gray-800">{{ $booking->user->name }}</p>
                    <p class="text-xs text-gray-400">Tanda Tangan Customer</p>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-6 pt-4 border-t border-gray-100">
                *Laporan ini hanya berlaku saat pengecekan. Kami tidak bertanggung jawab untuk perbedaan kondisi yang terjadi setelah dilakukan pengecekan.
            </p>
        </div>
    </div>

</div>
@endsection
