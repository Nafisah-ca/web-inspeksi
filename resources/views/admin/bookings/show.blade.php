@extends('layouts.admin')
@section('title', 'Detail Booking — ' . $booking->booking_code)
@section('page-title', 'Detail Booking')
@section('breadcrumb')
    <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-700">Semua Booking</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-gray-900">{{ $booking->booking_code }}</span>
@endsection

@section('content')
<div class="grid lg:grid-cols-3 gap-6">

    {{-- ============================
         KOLOM KIRI (2/3): Info utama
         ============================ --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Kode & Status --}}
        <div class="card p-5">
            <div class="flex items-start justify-between flex-wrap gap-3 mb-4">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-1">Nomor Booking</p>
                    <p class="text-2xl font-mono font-bold text-gray-900">{{ $booking->booking_code }}</p>
                </div>
                <span class="badge-{{ $booking->status_color }} text-sm px-3 py-1.5">{{ $booking->status_label }}</span>
            </div>

            {{-- Alur status --}}
            @php
                $steps = [
                    'pending'     => ['label' => 'Menunggu Konfirmasi', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'confirmed'   => ['label' => 'Dikonfirmasi',        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'on_progress' => ['label' => 'Sedang Dilayani',     'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    'completed'   => ['label' => 'Selesai',             'icon' => 'M5 13l4 4L19 7'],
                ];
                $stepKeys   = array_keys($steps);
                $currentIdx = array_search($booking->status, $stepKeys);
            @endphp

            @if($booking->status !== 'cancelled')
            <div class="flex items-center gap-1 overflow-x-auto py-1">
                @foreach($steps as $key => $step)
                @php
                    $idx   = array_search($key, $stepKeys);
                    $done  = $currentIdx !== false && $idx < $currentIdx;
                    $active = $key === $booking->status;
                @endphp
                <div class="flex items-center gap-1 shrink-0">
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center
                            {{ $active ? 'bg-blue-600 text-white' : ($done ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-xs mt-1 font-medium {{ $active ? 'text-blue-600' : ($done ? 'text-green-600' : 'text-gray-400') }} whitespace-nowrap">
                            {{ $step['label'] }}
                        </span>
                    </div>
                    @if(!$loop->last)
                    <div class="w-8 h-0.5 mb-4 {{ $done ? 'bg-green-400' : 'bg-gray-200' }} shrink-0"></div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="flex items-center gap-2 bg-red-50 rounded-xl px-4 py-2.5">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="text-sm font-medium text-red-700">Booking ini telah dibatalkan</span>
            </div>
            @endif

            <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400">Tanggal Booking</p>
                    <p class="font-semibold text-gray-900">{{ $booking->booking_date->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Waktu</p>
                    <p class="font-semibold text-gray-900">{{ substr($booking->booking_time, 0, 5) }} WIB</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Dibuat</p>
                    <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Harga Paket</p>
                    <p class="font-bold text-blue-600">{{ $booking->package->formatted_price }}</p>
                </div>
            </div>

            @if($booking->notes)
            <div class="mt-4 bg-gray-50 rounded-xl p-3">
                <p class="text-xs text-gray-500 font-semibold mb-1">Catatan Customer</p>
                <p class="text-sm text-gray-700">{{ $booking->notes }}</p>
            </div>
            @endif

            @if($booking->cancellation_reason)
            <div class="mt-4 bg-red-50 rounded-xl p-3 border border-red-100">
                <p class="text-xs text-red-500 font-semibold mb-1">Alasan Pembatalan</p>
                <p class="text-sm text-red-700">{{ $booking->cancellation_reason }}</p>
            </div>
            @endif
        </div>

        {{-- Data Customer & Kendaraan --}}
        <div class="grid sm:grid-cols-2 gap-5">
            <div class="card p-5">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Data Pelanggan
                </h3>
                <dl class="space-y-2 text-sm">
                    <div><dt class="text-xs text-gray-400">Nama</dt><dd class="font-medium text-gray-900">{{ $booking->user->name }}</dd></div>
                    <div><dt class="text-xs text-gray-400">Email</dt><dd class="font-medium text-gray-900 break-all">{{ $booking->user->email }}</dd></div>
                    <div><dt class="text-xs text-gray-400">No. HP</dt><dd class="font-medium text-gray-900">{{ $booking->user->phone ?? '—' }}</dd></div>
                </dl>
            </div>

            <div class="card p-5">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                    Data Kendaraan
                </h3>
                <dl class="space-y-2 text-sm">
                    <div><dt class="text-xs text-gray-400">Kendaraan</dt><dd class="font-medium text-gray-900">{{ $booking->vehicle->year }} {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</dd></div>
                    <div><dt class="text-xs text-gray-400">No. Plat</dt><dd class="font-medium text-gray-900 font-mono">{{ $booking->vehicle->plate_number }}</dd></div>
                    <div><dt class="text-xs text-gray-400">Tipe</dt><dd class="font-medium text-gray-900">{{ $booking->vehicle->getTypeLabel() }}</dd></div>
                </dl>
            </div>
        </div>

        {{-- Paket Inspeksi --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-3 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Paket Inspeksi
            </h3>
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <p class="font-semibold text-gray-900">{{ $booking->package->name }}</p>
                    @if($booking->package->description)
                    <p class="text-sm text-gray-500 mt-0.5">{{ $booking->package->description }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-xl font-bold text-blue-600">{{ $booking->package->formatted_price }}</p>
                    <p class="text-xs text-gray-400">{{ $booking->package->duration_label }}</p>
                </div>
            </div>
        </div>

        {{-- Hasil Inspeksi (jika ada) --}}
        @if($booking->result)
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Hasil Inspeksi
            </h3>

            <div class="flex gap-3 mb-4">
                <div class="flex-1 bg-green-50 rounded-xl p-3 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $booking->result->ok_count }}</p>
                    <p class="text-xs text-green-600 font-medium">OK</p>
                </div>
                <div class="flex-1 bg-yellow-50 rounded-xl p-3 text-center">
                    <p class="text-2xl font-bold text-yellow-600">{{ $booking->result->warning_count }}</p>
                    <p class="text-xs text-yellow-600 font-medium">Perhatian</p>
                </div>
                <div class="flex-1 bg-red-50 rounded-xl p-3 text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $booking->result->bad_count }}</p>
                    <p class="text-xs text-red-600 font-medium">Bermasalah</p>
                </div>
            </div>

            @if($booking->result->checklist_json)
            <div class="space-y-2 mb-4 max-h-72 overflow-y-auto pr-1">
                @foreach(collect($booking->result->checklist_json)->groupBy('category') as $cat => $items)
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-1">{{ $cat }}</p>
                    @foreach($items as $item)
                    <div class="flex items-center gap-3 py-1.5 px-3 rounded-lg {{ ['ok'=>'bg-green-50','warning'=>'bg-yellow-50','bad'=>'bg-red-50'][$item['status']] ?? 'bg-gray-50' }}">
                        <span class="text-base">{{ ['ok'=>'✅','warning'=>'⚠️','bad'=>'❌'][$item['status']] ?? '•' }}</span>
                        <span class="text-sm flex-1">{{ $item['item_name'] }}</span>
                        @if(!empty($item['note']))
                        <span class="text-xs text-gray-500 italic">{{ $item['note'] }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endif

            <div class="space-y-3 text-sm">
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Ringkasan Kondisi</p>
                    <p class="text-gray-600 bg-gray-50 p-3 rounded-xl leading-relaxed">{{ $booking->result->condition_summary }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Rekomendasi</p>
                    <p class="text-gray-600 bg-blue-50 p-3 rounded-xl leading-relaxed">{{ $booking->result->recommendation }}</p>
                </div>
                @if($booking->result->inspector_notes)
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Catatan Inspektor</p>
                    <p class="text-gray-600 bg-gray-50 p-3 rounded-xl">{{ $booking->result->inspector_notes }}</p>
                </div>
                @endif
                @if($booking->result->completed_at)
                <p class="text-xs text-gray-400">Diselesaikan: {{ $booking->result->completed_at->format('d M Y H:i') }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- ============================
         KOLOM KANAN (1/3): Aksi
         ============================ --}}
    <div class="space-y-4">

        {{-- ===== AKSI BERDASARKAN STATUS ===== --}}

        @if($booking->status === 'pending')
        {{-- Konfirmasi --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-1 text-sm">Konfirmasi Booking</h3>
            <p class="text-xs text-gray-500 mb-3">Booking ini menunggu konfirmasi admin.</p>
            <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-2.5 px-4 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Konfirmasi Booking
                </button>
            </form>
        </div>
        @endif

        @if($booking->status === 'confirmed')
        {{-- Mulai Dilayani --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-1 text-sm">Mulai Layanan</h3>
            <p class="text-xs text-gray-500 mb-3">Pelanggan sudah datang dan inspeksi dimulai.</p>
            <form method="POST" action="{{ route('admin.bookings.start', $booking) }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-2.5 px-4 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Mulai Dilayani
                </button>
            </form>
        </div>
        @endif

        @if($booking->status === 'on_progress')
        {{-- Selesaikan --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-1 text-sm">Selesaikan Inspeksi</h3>
            <p class="text-xs text-gray-500 mb-3">Proses inspeksi telah selesai dilakukan.</p>
            <form method="POST" action="{{ route('admin.bookings.complete', $booking) }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm py-2.5 px-4 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Selesaikan Booking
                </button>
            </form>
        </div>
        @endif

        @if($booking->status === 'completed')
        <div class="card p-5 border-green-200 bg-green-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-green-800 text-sm">Booking Selesai</p>
                    <p class="text-xs text-green-600">Proses inspeksi telah selesai.</p>
                </div>
            </div>
        </div>
        @endif

        @if($booking->status === 'cancelled')
        <div class="card p-5 border-red-200 bg-red-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-400 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-red-700 text-sm">Booking Dibatalkan</p>
                    <p class="text-xs text-red-500">Tidak ada tindakan lebih lanjut.</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Assign Inspektor (pending & confirmed saja) --}}
        @if(in_array($booking->status, ['pending', 'confirmed']))
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-3 text-sm">Assign Inspektor</h3>
            @if($booking->inspector)
            <div class="flex items-center gap-2 mb-3 bg-blue-50 rounded-lg px-3 py-2">
                <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    {{ strtoupper(substr($booking->inspector->name, 0, 2)) }}
                </div>
                <span class="text-sm font-medium text-blue-800">{{ $booking->inspector->name }}</span>
            </div>
            @endif
            <form method="POST" action="{{ route('admin.bookings.assign', $booking) }}">
                @csrf
                <select name="inspector_id" class="form-input mb-3" required>
                    <option value="">— Pilih Inspektor —</option>
                    @foreach($inspectors as $inspector)
                    <option value="{{ $inspector->id }}" {{ $booking->inspector_id == $inspector->id ? 'selected' : '' }}>
                        {{ $inspector->name }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full justify-center btn-sm">
                    {{ $booking->inspector ? 'Ganti Inspektor' : 'Assign Inspektor' }}
                </button>
            </form>
        </div>
        @elseif($booking->inspector)
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-2 text-sm">Inspektor</h3>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    {{ strtoupper(substr($booking->inspector->name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $booking->inspector->name }}</p>
                    <p class="text-xs text-gray-400">{{ $booking->inspector->email }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Batalkan (hanya pending & confirmed) --}}
        @if(in_array($booking->status, ['pending', 'confirmed']))
        <div class="card p-5" x-data="{ open: false }">
            <h3 class="font-semibold text-gray-900 mb-3 text-sm">Batalkan Booking</h3>
            <button @click="open = !open"
                    class="w-full flex items-center justify-center gap-2 border border-red-300 text-red-600 hover:bg-red-50 font-semibold text-sm py-2.5 px-4 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batalkan Booking
            </button>
            <div x-show="open" x-transition class="mt-3">
                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
                    @csrf
                    <textarea name="cancellation_reason" rows="2" class="form-input mb-2 text-sm"
                              placeholder="Tuliskan alasan pembatalan (opsional)..."></textarea>
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold text-sm py-2 px-4 rounded-xl transition-colors">
                        Konfirmasi Batalkan
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Hasil Inspeksi --}}
        @if($booking->result)
        <a href="{{ route('admin.results.show', $booking) }}"
           class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 px-4 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Lihat Laporan Inspeksi
        </a>
        @elseif(in_array($booking->status, ['confirmed', 'on_progress', 'completed']))
        <a href="{{ route('admin.results.create', $booking) }}"
           class="w-full flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm py-2.5 px-4 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Input Hasil Inspeksi
        </a>
        @endif

        {{-- Kembali --}}
        <a href="{{ route('admin.bookings.index') }}"
           class="flex items-center justify-center gap-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 py-2.5 px-4 rounded-xl border border-gray-200 transition-colors w-full">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Booking
        </a>

</div>
@endsection
