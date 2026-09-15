<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Inspektor — InspeksiKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

{{-- Top nav --}}
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <span class="font-bold text-gray-900">InspeksiKu</span>
            <span class="badge-indigo ml-1">Inspektor</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-600 hidden sm:block">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-secondary btn-sm">Keluar</button>
            </form>
        </div>
    </div>
</nav>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
     class="fixed top-16 right-4 z-50 max-w-sm w-full" x-transition>
    <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 shadow-lg">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

<main class="max-w-4xl mx-auto px-4 sm:px-6 py-6">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}! 🔧</h1>
        <p class="text-sm text-gray-500">Daftar tugas inspeksi yang di-assign untuk Anda.</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-3 mb-6">
        @foreach([
            ['Total Tugas',   $stats['total'],       'bg-gray-100   text-gray-700'],
            ['Dikerjakan',    $stats['on_progress'],  'bg-indigo-100 text-indigo-700'],
            ['Selesai',       $stats['completed'],    'bg-green-100  text-green-700'],
        ] as [$label, $val, $cls])
        <div class="card p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $val }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $label }}</p>
        </div>
        @endforeach
    </div>

    {{-- Active Tasks --}}
    <h2 class="text-base font-semibold text-gray-900 mb-3">Tugas Aktif</h2>

    @if($activeTasks->isEmpty())
    <div class="card p-10 text-center mb-6">
        <div class="text-4xl mb-3">✅</div>
        <p class="font-semibold text-gray-900 mb-1">Tidak ada tugas aktif</p>
        <p class="text-sm text-gray-500">Semua tugas sudah selesai atau belum ada yang di-assign.</p>
    </div>
    @else
    <div class="space-y-4 mb-6">
        @foreach($activeTasks as $booking)
        <div class="card p-5">
            <div class="flex items-start justify-between gap-3 mb-3">
                <div>
                    <p class="font-mono text-xs text-gray-400">{{ $booking->booking_code }}</p>
                    <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }} · {{ $booking->vehicle->plate_number }}</p>
                </div>
                <span class="badge-{{ $booking->status_color }} shrink-0">{{ $booking->status_label }}</span>
            </div>
            <div class="flex flex-wrap gap-4 text-xs text-gray-500 mb-4">
                <span>📅 {{ $booking->booking_date->format('d M Y') }}</span>
                <span>🕐 {{ substr($booking->booking_time, 0, 5) }} WIB</span>
                <span>📦 {{ $booking->package->name }}</span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('inspector.tasks.show', $booking) }}" class="btn-primary btn-sm">
                    @if($booking->status === 'confirmed') Mulai Inspeksi @else Lanjutkan @endif
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Recent completed --}}
    @if($completedTasks->isNotEmpty())
    <h2 class="text-base font-semibold text-gray-900 mb-3">Selesai Terbaru</h2>
    <div class="card divide-y divide-gray-50">
        @foreach($completedTasks as $booking)
        <div class="px-5 py-3 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
                <p class="text-xs text-gray-500">{{ $booking->booking_date->format('d M Y') }} · {{ $booking->package->name }}</p>
            </div>
            <span class="badge-green">Selesai</span>
        </div>
        @endforeach
    </div>
    @endif

</main>
</body>
</html>
