@extends('layouts.user')
@section('title', 'Dashboard')

@section('content')

{{-- Greeting --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-sm text-gray-500 mt-0.5">Pantau status inspeksi kendaraan Anda di sini.</p>
    </div>
    <a href="{{ route('booking.create') }}" class="btn-primary btn-sm hidden sm:inline-flex">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Booking Baru
    </a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    @foreach([
        ['Total Booking',  $stats['total'],       'bg-blue-50   text-blue-600',   '🗓'],
        ['Berlangsung',    $stats['on_progress'],  'bg-indigo-50 text-indigo-600', '🔧'],
        ['Menunggu',       $stats['pending'],      'bg-yellow-50 text-yellow-600', '⏳'],
        ['Selesai',        $stats['completed'],    'bg-green-50  text-green-600',  '✅'],
    ] as [$label, $val, $cls, $icon])
    <div class="card p-4">
        <div class="text-2xl mb-1">{{ $icon }}</div>
        <p class="text-2xl font-bold text-gray-900">{{ $val }}</p>
        <p class="text-xs text-gray-500">{{ $label }}</p>
    </div>
    @endforeach
</div>

{{-- Active Bookings --}}
@if($activeBookings->isNotEmpty())
<div class="mb-6">
    <h2 class="text-base font-semibold text-gray-900 mb-3">Booking Aktif</h2>
    <div class="space-y-4">
        @foreach($activeBookings as $booking)
        <div class="card p-5">
            {{-- Header --}}
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <p class="font-mono text-xs text-gray-400">{{ $booking->booking_code }}</p>
                    <p class="font-semibold text-gray-900 mt-0.5">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
                    <p class="text-xs text-gray-500">{{ $booking->vehicle->plate_number }} · {{ $booking->package->name }}</p>
                </div>
                <span class="badge-{{ $booking->status_color }} shrink-0">{{ $booking->status_label }}</span>
            </div>

            {{-- Progress tracker --}}
            <div class="mb-4">
                @php
                    $steps = ['pending' => 0, 'confirmed' => 1, 'on_progress' => 2, 'completed' => 3];
                    $current = $steps[$booking->status] ?? 0;
                    $labels  = ['Booking', 'Dikonfirmasi', 'Dikerjakan', 'Selesai'];
                @endphp
                <div class="flex items-center">
                    @foreach($labels as $i => $label)
                    <div class="flex items-center {{ $i < count($labels) - 1 ? 'flex-1' : '' }}">
                        <div class="flex flex-col items-center">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                                        {{ $i <= $current ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                @if($i < $current)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    {{ $i + 1 }}
                                @endif
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1 whitespace-nowrap">{{ $label }}</p>
                        </div>
                        @if($i < count($labels) - 1)
                        <div class="flex-1 h-0.5 mx-1 mb-3 {{ $i < $current ? 'bg-blue-500' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Info row --}}
            <div class="flex flex-wrap gap-4 text-xs text-gray-500 mb-4">
                <span>📅 {{ $booking->booking_date->format('d M Y') }} · {{ substr($booking->booking_time, 0, 5) }} WIB</span>
                @if($booking->inspector)
                <span>👨‍🔧 {{ $booking->inspector->name }}</span>
                @else
                <span class="text-yellow-500">⏳ Menunggu assign inspektor</span>
                @endif
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.bookings.show', $booking) }}" class="btn-secondary btn-sm">Lihat Detail</a>
                @if(in_array($booking->status, ['pending', 'confirmed']))
                <form method="POST" action="{{ route('user.bookings.cancel', $booking) }}"
                      onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                    @csrf
                    <button type="submit" class="btn-danger btn-sm">Batalkan</button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
{{-- Empty state --}}
<div class="card p-10 text-center mb-6">
    <div class="text-5xl mb-3">🚗</div>
    <h3 class="font-semibold text-gray-900 mb-1">Belum ada booking aktif</h3>
    <p class="text-sm text-gray-500 mb-4">Yuk, jadwalkan inspeksi kendaraan Anda sekarang!</p>
    <a href="{{ route('booking.create') }}" class="btn-primary">
        Booking Sekarang
    </a>
</div>
@endif

{{-- Recent completed --}}
@if($recentCompleted->isNotEmpty())
<div>
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-base font-semibold text-gray-900">Riwayat Terakhir</h2>
        <a href="{{ route('user.bookings') }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
    </div>
    <div class="card divide-y divide-gray-50">
        @foreach($recentCompleted as $booking)
        <a href="{{ route('user.bookings.show', $booking) }}"
           class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition-colors">
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
                <p class="text-xs text-gray-500">{{ $booking->package->name }} · {{ $booking->booking_date->format('d M Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="badge-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- Mobile FAB --}}
<div class="sm:hidden fixed bottom-6 right-6">
    <a href="{{ route('booking.create') }}"
       class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full shadow-xl text-white hover:bg-blue-700 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
    </a>
</div>

@endsection
