@extends('layouts.user')
@section('title', 'Detail Booking')

@section('content')

<div class="mb-5">
    <a href="{{ route('user.bookings') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Riwayat
    </a>
</div>

{{-- Status card --}}
<div class="card p-5 mb-5">
    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Kode Booking</p>
            <p class="text-xl font-mono font-bold text-gray-900">{{ $booking->booking_code }}</p>
        </div>
        <span class="badge-{{ $booking->status_color }} text-sm px-3 py-1">{{ $booking->status_label }}</span>
    </div>

    {{-- Progress bar --}}
    @if($booking->status !== 'cancelled')
    @php
        $steps   = ['pending' => 0, 'confirmed' => 1, 'on_progress' => 2, 'completed' => 3];
        $current = $steps[$booking->status] ?? 0;
        $labels  = ['Booking', 'Dikonfirmasi', 'Dikerjakan', 'Selesai'];
    @endphp
    <div class="flex items-center mb-4">
        @foreach($labels as $i => $label)
        <div class="flex items-center {{ $i < count($labels) - 1 ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $i < $current ? 'bg-blue-600 text-white' : ($i === $current ? 'bg-blue-600 text-white ring-4 ring-blue-100' : 'bg-gray-200 text-gray-400') }}">
                    @if($i < $current)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $i + 1 }}
                    @endif
                </div>
                <p class="text-[10px] text-center mt-1 {{ $i <= $current ? 'text-blue-600 font-semibold' : 'text-gray-400' }}">
                    {{ $label }}
                </p>
            </div>
            @if($i < count($labels) - 1)
            <div class="flex-1 h-1 mx-1 mb-4 rounded-full {{ $i < $current ? 'bg-blue-500' : 'bg-gray-200' }}"></div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-red-50 rounded-xl px-4 py-3 mb-4">
        <p class="text-sm font-semibold text-red-700">Booking Dibatalkan</p>
        @if($booking->cancellation_reason)
        <p class="text-xs text-red-600 mt-1">{{ $booking->cancellation_reason }}</p>
        @endif
    </div>
    @endif

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
        <div><p class="text-gray-400 text-xs">Tanggal</p><p class="font-semibold">{{ $booking->booking_date->format('d M Y') }}</p></div>
        <div><p class="text-gray-400 text-xs">Waktu</p><p class="font-semibold">{{ substr($booking->booking_time, 0, 5) }} WIB</p></div>
        <div><p class="text-gray-400 text-xs">Paket</p><p class="font-semibold">{{ $booking->package->name }}</p></div>
        <div><p class="text-gray-400 text-xs">Harga</p><p class="font-bold text-blue-600">{{ $booking->package->formatted_price }}</p></div>
    </div>

    @if($booking->inspector)
    <div class="mt-4 bg-indigo-50 rounded-xl px-4 py-3 flex items-center gap-3">
        <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
            {{ strtoupper(substr($booking->inspector->name, 0, 2)) }}
        </div>
        <div>
            <p class="text-xs text-indigo-500 font-semibold">Inspektor</p>
            <p class="text-sm font-semibold text-indigo-900">{{ $booking->inspector->name }}</p>
        </div>
    </div>
    @endif
</div>

{{-- Vehicle info --}}
<div class="card p-5 mb-5">
    <h2 class="font-semibold text-gray-900 mb-3">Kendaraan</h2>
    <div class="grid grid-cols-2 gap-3 text-sm">
        <div><p class="text-gray-400 text-xs">Merek & Model</p><p class="font-medium">{{ $booking->vehicle->year }} {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p></div>
        <div><p class="text-gray-400 text-xs">No. Plat</p><p class="font-medium font-mono">{{ $booking->vehicle->plate_number }}</p></div>
        <div><p class="text-gray-400 text-xs">Tipe</p><p class="font-medium">{{ $booking->vehicle->getTypeLabel() }}</p></div>
    </div>
    @if($booking->notes)
    <div class="mt-3 bg-gray-50 rounded-xl p-3">
        <p class="text-xs text-gray-500 font-semibold mb-1">Catatan</p>
        <p class="text-sm text-gray-700">{{ $booking->notes }}</p>
    </div>
    @endif
</div>

{{-- Inspection Result --}}
@if($booking->result && $booking->status === 'completed')
<div class="card p-5 mb-5">
    <h2 class="font-semibold text-gray-900 mb-4">🔍 Hasil Inspeksi</h2>

    {{-- Scores --}}
    <div class="grid grid-cols-3 gap-3 mb-5">
        <div class="bg-green-50 border border-green-100 rounded-xl p-3 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $booking->result->ok_count }}</p>
            <p class="text-xs text-green-600 font-semibold mt-1">✅ OK</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 text-center">
            <p class="text-3xl font-bold text-yellow-600">{{ $booking->result->warning_count }}</p>
            <p class="text-xs text-yellow-600 font-semibold mt-1">⚠️ Perhatian</p>
        </div>
        <div class="bg-red-50 border border-red-100 rounded-xl p-3 text-center">
            <p class="text-3xl font-bold text-red-600">{{ $booking->result->bad_count }}</p>
            <p class="text-xs text-red-600 font-semibold mt-1">❌ Bermasalah</p>
        </div>
    </div>

    {{-- Checklist --}}
    @if($booking->result->checklist_json)
    <div class="mb-5">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Detail Checklist</p>
        @foreach(collect($booking->result->checklist_json)->groupBy('category') as $category => $items)
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-600 uppercase mb-2 bg-gray-100 px-3 py-1 rounded-lg inline-block">{{ $category }}</p>
            <div class="space-y-1.5">
                @foreach($items as $item)
                @php
                    $bg   = ['ok' => 'bg-green-50 border-green-100',  'warning' => 'bg-yellow-50 border-yellow-100', 'bad' => 'bg-red-50 border-red-100'][$item['status']] ?? 'bg-gray-50 border-gray-100';
                    $icon = ['ok' => '✅', 'warning' => '⚠️', 'bad' => '❌'][$item['status']] ?? '•';
                @endphp
                <div class="flex items-start gap-2.5 p-3 rounded-xl border {{ $bg }}">
                    <span class="mt-0.5 text-sm">{{ $icon }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $item['item_name'] }}</p>
                        @if(!empty($item['note']))
                        <p class="text-xs text-gray-500 mt-0.5">{{ $item['note'] }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Summary & Recommendation --}}
    <div class="space-y-4">
        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">📋 Ringkasan Kondisi</p>
            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                {{ $booking->result->condition_summary }}
            </div>
        </div>
        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">💡 Rekomendasi</p>
            <div class="bg-blue-50 rounded-xl p-4 text-sm text-blue-800 leading-relaxed whitespace-pre-line">
                {{ $booking->result->recommendation }}
            </div>
        </div>
        @if($booking->result->inspector_notes)
        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">🔧 Catatan Inspektor</p>
            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700">
                {{ $booking->result->inspector_notes }}
            </div>
        </div>
        @endif
        @if($booking->result->completed_at)
        <p class="text-xs text-gray-400 text-right">
            Inspeksi selesai: {{ $booking->result->completed_at->format('d M Y, H:i') }} WIB
        </p>
        @endif
    </div>
</div>
@endif

{{-- Actions --}}
<div class="flex gap-3">
    @if(in_array($booking->status, ['pending', 'confirmed']))
    <form method="POST" action="{{ route('user.bookings.cancel', $booking) }}"
          onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
        @csrf
        <button type="submit" class="btn-danger">Batalkan Booking</button>
    </form>
    @endif
    @if($booking->status === 'completed')
    <a href="{{ route('booking.create', ['package_id' => $booking->package_id]) }}" class="btn-primary">
        Booking Ulang
    </a>
    @endif
</div>

@endsection
