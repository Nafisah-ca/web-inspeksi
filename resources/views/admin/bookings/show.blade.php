@extends('layouts.admin')
@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')
@section('breadcrumb')
    <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-700">Bookings</a>
    / {{ $booking->booking_code }}
@endsection

@section('content')
<div class="grid lg:grid-cols-3 gap-6">

    {{-- Main info --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Status & Code --}}
        <div class="card p-5">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-1">Kode Booking</p>
                    <p class="text-xl font-mono font-bold text-gray-900">{{ $booking->booking_code }}</p>
                </div>
                <span class="badge-{{ $booking->status_color }} text-sm px-3 py-1">{{ $booking->status_label }}</span>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">Tanggal Booking</p>
                    <p class="font-semibold text-gray-900">{{ $booking->booking_date->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Waktu</p>
                    <p class="font-semibold text-gray-900">{{ substr($booking->booking_time, 0, 5) }} WIB</p>
                </div>
                <div>
                    <p class="text-gray-400">Dibuat</p>
                    <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Paket</p>
                    <p class="font-semibold text-gray-900">{{ $booking->package->name }}</p>
                    <p class="text-blue-600 font-bold">{{ $booking->package->formatted_price }}</p>
                </div>
            </div>
            @if($booking->notes)
            <div class="mt-4 bg-gray-50 rounded-xl p-3">
                <p class="text-xs text-gray-500 font-semibold mb-1">Catatan Customer</p>
                <p class="text-sm text-gray-700">{{ $booking->notes }}</p>
            </div>
            @endif
            @if($booking->cancellation_reason)
            <div class="mt-4 bg-red-50 rounded-xl p-3">
                <p class="text-xs text-red-500 font-semibold mb-1">Alasan Pembatalan</p>
                <p class="text-sm text-red-700">{{ $booking->cancellation_reason }}</p>
            </div>
            @endif
        </div>

        {{-- Customer & Vehicle --}}
        <div class="grid sm:grid-cols-2 gap-5">
            <div class="card p-5">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Data Customer
                </h3>
                <dl class="space-y-2 text-sm">
                    <div><dt class="text-gray-400">Nama</dt><dd class="font-medium">{{ $booking->user->name }}</dd></div>
                    <div><dt class="text-gray-400">Email</dt><dd class="font-medium">{{ $booking->user->email }}</dd></div>
                    <div><dt class="text-gray-400">No. HP</dt><dd class="font-medium">{{ $booking->user->phone ?? '—' }}</dd></div>
                </dl>
            </div>

            <div class="card p-5">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                    Data Kendaraan
                </h3>
                <dl class="space-y-2 text-sm">
                    <div><dt class="text-gray-400">Kendaraan</dt><dd class="font-medium">{{ $booking->vehicle->year }} {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</dd></div>
                    <div><dt class="text-gray-400">No. Plat</dt><dd class="font-medium font-mono">{{ $booking->vehicle->plate_number }}</dd></div>
                    <div><dt class="text-gray-400">Tipe</dt><dd class="font-medium">{{ $booking->vehicle->getTypeLabel() }}</dd></div>
                </dl>
            </div>
        </div>

        {{-- Inspection Result --}}
        @if($booking->result)
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Hasil Inspeksi
            </h3>

            {{-- Checklist summary --}}
            <div class="flex gap-4 mb-4">
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
            <div class="space-y-2 mb-4 max-h-64 overflow-y-auto">
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
                    <p class="text-gray-600 leading-relaxed bg-gray-50 p-3 rounded-xl">{{ $booking->result->condition_summary }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Rekomendasi</p>
                    <p class="text-gray-600 leading-relaxed bg-blue-50 p-3 rounded-xl">{{ $booking->result->recommendation }}</p>
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

    {{-- Sidebar actions --}}
    <div class="space-y-5">

        {{-- Assign Inspector --}}
        @if(in_array($booking->status, ['pending', 'confirmed']))
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Assign Inspektor</h3>
            <form method="POST" action="{{ route('admin.bookings.assign', $booking) }}">
                @csrf
                <select name="inspector_id" class="form-input mb-3" required>
                    <option value="">Pilih Inspektor</option>
                    @foreach($inspectors as $inspector)
                    <option value="{{ $inspector->id }}" {{ $booking->inspector_id == $inspector->id ? 'selected' : '' }}>
                        {{ $inspector->name }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full justify-center btn-sm">
                    Assign
                </button>
            </form>
        </div>
        @endif

        {{-- Change Status --}}
        @if(!in_array($booking->status, ['completed', 'cancelled']))
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Ubah Status</h3>
            <form method="POST" action="{{ route('admin.bookings.status', $booking) }}">
                @csrf
                <select name="status" class="form-input mb-3">
                    @foreach(\App\Models\Booking::$statuses as $val => $label)
                    @if($val !== 'cancelled')
                    <option value="{{ $val }}" {{ $booking->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endif
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full justify-center btn-sm">Simpan</button>
            </form>
        </div>

        {{-- Cancel --}}
        <div class="card p-5" x-data="{ open: false }">
            <h3 class="font-semibold text-gray-900 mb-3">Batalkan Booking</h3>
            <button @click="open = true" class="btn-danger w-full justify-center btn-sm">Batalkan</button>
            <div x-show="open" x-transition class="mt-3">
                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
                    @csrf
                    <textarea name="cancellation_reason" rows="2" class="form-input mb-2 text-sm"
                              placeholder="Alasan pembatalan..."></textarea>
                    <button type="submit" class="btn-danger w-full justify-center btn-sm">Konfirmasi Batalkan</button>
                </form>
            </div>
        </div>
        @endif

        {{-- Quick confirm --}}
        @if($booking->status === 'pending')
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Konfirmasi Booking</h3>
            <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                @csrf
                <button type="submit" class="btn-success w-full justify-center btn-sm">
                    ✓ Konfirmasi Sekarang
                </button>
            </form>
        </div>
        @endif

        <a href="{{ route('admin.bookings.index') }}" class="btn-secondary w-full justify-center">
            ← Kembali ke Daftar
        </a>
    </div>
</div>
@endsection
