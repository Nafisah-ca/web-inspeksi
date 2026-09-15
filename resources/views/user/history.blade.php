@extends('layouts.user')
@section('title', 'Riwayat Booking')

@section('content')

<div class="flex items-center justify-between mb-5">
    <h1 class="text-xl font-bold text-gray-900">Riwayat Booking</h1>
    <a href="{{ route('booking.create') }}" class="btn-primary btn-sm hidden sm:inline-flex">+ Booking Baru</a>
</div>

{{-- Filter --}}
<div class="card p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="form-label">Filter Status</label>
            <select name="status" class="form-input" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach(\App\Models\Booking::$statuses as $val => $label)
                <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        @if(request('status'))
        <a href="{{ route('user.bookings') }}" class="btn-secondary btn-sm h-9">Reset</a>
        @endif
    </form>
</div>

@if($bookings->isEmpty())
<div class="card p-12 text-center">
    <div class="text-5xl mb-3">📋</div>
    <p class="font-semibold text-gray-900 mb-1">Tidak ada booking ditemukan</p>
    <p class="text-sm text-gray-500 mb-4">
        @if(request('status'))
            Tidak ada booking dengan status "{{ \App\Models\Booking::$statuses[request('status')] ?? request('status') }}".
        @else
            Anda belum pernah melakukan booking.
        @endif
    </p>
    <a href="{{ route('booking.create') }}" class="btn-primary">Booking Sekarang</a>
</div>
@else
<div class="space-y-3">
    @foreach($bookings as $booking)
    <div class="card p-4 hover:shadow-md transition-shadow">
        <div class="flex items-start gap-4">
            {{-- Icon --}}
            <div class="w-10 h-10 rounded-xl bg-{{ $booking->status_color }}-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-{{ $booking->status_color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                </svg>
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->vehicle->plate_number }} · {{ $booking->package->name }}</p>
                    </div>
                    <span class="badge-{{ $booking->status_color }} shrink-0">{{ $booking->status_label }}</span>
                </div>
                <div class="flex flex-wrap gap-3 text-xs text-gray-400 mb-3">
                    <span>📅 {{ $booking->booking_date->format('d M Y') }}</span>
                    <span>🕐 {{ substr($booking->booking_time, 0, 5) }}</span>
                    <span class="font-mono">{{ $booking->booking_code }}</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('user.bookings.show', $booking) }}" class="btn-secondary btn-sm">
                        @if($booking->status === 'completed' && $booking->result)
                            Lihat Hasil Inspeksi
                        @else
                            Lihat Detail
                        @endif
                    </a>
                    @if(in_array($booking->status, ['pending', 'confirmed']))
                    <form method="POST" action="{{ route('user.bookings.cancel', $booking) }}"
                          onsubmit="return confirm('Yakin ingin membatalkan?')">
                        @csrf
                        <button type="submit" class="btn-danger btn-sm">Batalkan</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
@if($bookings->hasPages())
<div class="mt-6">{{ $bookings->links() }}</div>
@endif
@endif

@endsection
