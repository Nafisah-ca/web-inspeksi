@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Pending',       $stats['pending'],     'yellow', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Dikonfirmasi',  $stats['confirmed'],   'blue',   'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Dikerjakan',    $stats['on_progress'], 'indigo', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
        ['Selesai',       $stats['completed'],   'green',  'M5 13l4 4L19 7'],
    ] as [$label, $count, $color, $icon])
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
            <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-{{ $color }}-100">
                <svg class="w-5 h-5 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $count }}</p>
        <p class="text-xs text-gray-400 mt-1">booking</p>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    {{-- Chart --}}
    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-900">Booking 7 Hari Terakhir</h2>
        </div>
        <div class="flex items-end gap-2 h-36" x-data>
            @php $maxCount = max(array_column($chartData, 'count') ?: [1]); @endphp
            @foreach($chartData as $day)
            @php $height = $maxCount > 0 ? round(($day['count'] / $maxCount) * 100) : 0; @endphp
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-xs text-gray-500 font-medium">{{ $day['count'] }}</span>
                <div class="w-full bg-blue-100 rounded-t-md transition-all"
                     style="height: {{ max($height, 4) }}%"
                     title="{{ $day['date'] }}: {{ $day['count'] }} booking">
                    <div class="w-full h-full bg-blue-500 rounded-t-md opacity-80 hover:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-xs text-gray-400">{{ $day['date'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Summary --}}
    <div class="card p-5">
        <h2 class="font-semibold text-gray-900 mb-4">Ringkasan</h2>
        <div class="space-y-3">
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Total Booking</span>
                <span class="font-bold text-gray-900">{{ $stats['total'] }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Total Customer</span>
                <span class="font-bold text-gray-900">{{ $stats['customers'] }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Total Inspektor</span>
                <span class="font-bold text-gray-900">{{ $stats['inspectors'] }}</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-sm text-gray-600">Dibatalkan</span>
                <span class="font-bold text-red-500">{{ $stats['cancelled'] }}</span>
            </div>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn-primary w-full justify-center mt-4 btn-sm">
            Lihat Semua Booking
        </a>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Today's bookings --}}
    <div class="card">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Jadwal Hari Ini</h2>
            <span class="badge-blue">{{ $todayBookings->count() }} booking</span>
        </div>
        @if($todayBookings->isEmpty())
        <div class="px-5 py-8 text-center text-gray-400 text-sm">Tidak ada booking hari ini</div>
        @else
        <div class="divide-y divide-gray-50">
            @foreach($todayBookings as $booking)
            <div class="px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 text-xs font-bold">
                            {{ substr($booking->booking_time, 0, 5) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }} · {{ $booking->package->name }}</p>
                        </div>
                    </div>
                    <span class="badge-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Recent bookings --}}
    <div class="card">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Booking Terbaru</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($recentBookings as $booking)
            <a href="{{ route('admin.bookings.show', $booking) }}"
               class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $booking->booking_code }}</p>
                    <p class="text-xs text-gray-500">{{ $booking->user->name }} · {{ $booking->booking_date->format('d M Y') }}</p>
                </div>
                <span class="badge-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
