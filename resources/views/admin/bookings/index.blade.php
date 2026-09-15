@extends('layouts.admin')
@section('title', 'Kelola Booking')
@section('page-title', 'Kelola Booking')

@section('content')
{{-- Filters --}}
<div class="card p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="form-label">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-input" placeholder="Kode booking, nama, plat...">
        </div>
        <div class="min-w-[160px]">
            <label class="form-label">Status</label>
            <select name="status" class="form-input">
                <option value="">Semua Status</option>
                @foreach(\App\Models\Booking::$statuses as $val => $label)
                <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[160px]">
            <label class="form-label">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="form-input">
        </div>
        <button type="submit" class="btn-primary btn-sm h-9">Filter</button>
        @if(request()->hasAny(['search','status','date']))
        <a href="{{ route('admin.bookings.index') }}" class="btn-secondary btn-sm h-9">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">Kode</th>
                    <th class="table-th">Customer</th>
                    <th class="table-th">Kendaraan</th>
                    <th class="table-th">Paket</th>
                    <th class="table-th">Jadwal</th>
                    <th class="table-th">Inspektor</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="table-td">
                        <span class="font-mono text-xs font-semibold text-gray-900">{{ $booking->booking_code }}</span>
                    </td>
                    <td class="table-td">
                        <p class="font-medium text-gray-900 text-sm">{{ $booking->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $booking->user->phone }}</p>
                    </td>
                    <td class="table-td">
                        <p class="text-sm text-gray-900">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
                        <p class="text-xs text-gray-400">{{ $booking->vehicle->plate_number }}</p>
                    </td>
                    <td class="table-td text-sm">{{ $booking->package->name }}</td>
                    <td class="table-td">
                        <p class="text-sm font-medium">{{ $booking->booking_date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ substr($booking->booking_time, 0, 5) }} WIB</p>
                    </td>
                    <td class="table-td text-sm text-gray-500">
                        {{ $booking->inspector?->name ?? '—' }}
                    </td>
                    <td class="table-td">
                        <span class="badge-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
                    </td>
                    <td class="table-td">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.bookings.show', $booking) }}"
                               class="btn-secondary btn-sm py-1 px-2.5">Detail</a>

                            @if($booking->status === 'pending')
                            <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                                @csrf
                                <button type="submit" class="btn-success btn-sm py-1 px-2.5" title="Konfirmasi">✓</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="table-td text-center text-gray-400 py-10">
                        Tidak ada booking ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
