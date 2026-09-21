@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stat Cards: 5 status booking --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    @foreach([
        ['Menunggu Konfirmasi', $stats['pending'],     'yellow', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',    'pending'],
        ['Dikonfirmasi',        $stats['confirmed'],   'blue',   'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',           'confirmed'],
        ['Sedang Dilayani',     $stats['on_progress'], 'indigo', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'on_progress'],
        ['Selesai',             $stats['completed'],   'green',  'M5 13l4 4L19 7',                                           'completed'],
        ['Dibatalkan',          $stats['cancelled'],   'red',    'M6 18L18 6M6 6l12 12',                                     'cancelled'],
    ] as [$label, $count, $color, $icon, $status])
    <a href="{{ route('admin.bookings.index', ['status' => $status]) }}"
       class="card p-4 hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-medium text-gray-500 leading-tight">{{ $label }}</p>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-{{ $color }}-100 group-hover:scale-110 transition-transform shrink-0">
                <svg class="w-4 h-4 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $count }}</p>
        <p class="text-xs text-gray-400 mt-0.5">booking</p>
    </a>
    @endforeach
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    {{-- Bar chart 7 hari --}}
    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-900">Booking 7 Hari Terakhir</h2>
            <span class="text-xs text-gray-400">{{ now()->subDays(6)->format('d M') }} – {{ now()->format('d M Y') }}</span>
        </div>
        <div class="flex items-end gap-2 h-36">
            @php $maxCount = max(array_column($chartData, 'count') ?: [1]); @endphp
            @foreach($chartData as $day)
            @php $height = $maxCount > 0 ? round(($day['count'] / $maxCount) * 100) : 0; @endphp
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-xs text-gray-500 font-medium">{{ $day['count'] ?: '' }}</span>
                <div class="w-full rounded-t-md transition-all bg-blue-100" style="height: {{ max($height, 4) }}%">
                    <div class="w-full h-full bg-blue-500 rounded-t-md opacity-80 hover:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-xs text-gray-400">{{ $day['date'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="card p-5">
        <h2 class="font-semibold text-gray-900 mb-4">Ringkasan</h2>
        <div class="space-y-2.5">
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Total Booking</span>
                <span class="font-bold text-gray-900">{{ $stats['total'] }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Booking Hari Ini</span>
                <span class="font-bold text-blue-600">{{ $stats['today'] }}</span>
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
    {{-- Jadwal hari ini --}}
    <div class="card">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Jadwal Hari Ini</h2>
            <span class="badge-blue">{{ $todayBookings->count() }} booking</span>
        </div>
        @if($todayBookings->isEmpty())
        <div class="px-5 py-10 text-center text-gray-400 text-sm">
            <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Tidak ada booking hari ini
        </div>
        @else
        <div class="divide-y divide-gray-50">
            @foreach($todayBookings as $booking)
            <a href="{{ route('admin.bookings.show', $booking) }}"
               class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                        {{ substr($booking->booking_time, 0, 5) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $booking->user->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }} · {{ $booking->package->name }}</p>
                    </div>
                </div>
                <div class="ml-2 shrink-0 text-right">
                    <span class="badge-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
                    @if($booking->inspector)
                    <p class="text-xs text-gray-400 mt-0.5">{{ $booking->inspector->name }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Booking terbaru --}}
    <div class="card">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Booking Terbaru</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
        </div>
        @if($recentBookings->isEmpty())
        <div class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada booking</div>
        @else
        <div class="divide-y divide-gray-50">
            @foreach($recentBookings as $booking)
            <a href="{{ route('admin.bookings.show', $booking) }}"
               class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 font-mono">{{ $booking->booking_code }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $booking->user->name }} · {{ $booking->booking_date->format('d M Y') }}</p>
                </div>
                <span class="badge-{{ $booking->status_color }} ml-2 shrink-0">{{ $booking->status_label }}</span>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Quick Actions --}}
<div class="mt-6">
    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Aksi Cepat</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach([
            ['Tambah Booking',  'admin.bookings.create',   'bg-blue-50 text-blue-600',    'M12 4v16m8-8H4'],
            ['Paket Inspeksi',  'admin.packages.index',    'bg-purple-50 text-purple-600','M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['Item Checklist',  'admin.checklist.index',   'bg-green-50 text-green-600',  'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
            ['Kelola Inspektor','admin.inspectors.index',  'bg-orange-50 text-orange-600','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ] as [$label, $route, $cls, $path])
        <a href="{{ route($route) }}"
           class="card p-4 hover:shadow-md transition-shadow flex items-center gap-3 group">
            <div class="w-9 h-9 {{ $cls }} rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
        </a>
        @endforeach
        {{-- Semua Booking --}}
        <a href="{{ route('admin.bookings.index') }}"
           class="card p-4 hover:shadow-md transition-shadow flex items-center gap-3 group">
            <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Semua Booking</span>
        </a>
    </div>
</div>

@endsection
