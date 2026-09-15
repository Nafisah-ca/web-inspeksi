@extends('layouts.admin')
@section('title', 'Paket Inspeksi')
@section('page-title', 'Paket Inspeksi')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-sm text-gray-500">{{ $packages->count() }} paket terdaftar</p>
    <a href="{{ route('admin.packages.create') }}" class="btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Paket
    </a>
</div>

<div class="grid md:grid-cols-3 gap-5">
    @forelse($packages as $package)
    <div class="card p-5 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-3">
            <div>
                <h3 class="font-semibold text-gray-900">{{ $package->name }}</h3>
                <p class="text-blue-600 font-bold text-lg">{{ $package->formatted_price }}</p>
            </div>
            <span class="{{ $package->is_active ? 'badge-green' : 'badge-gray' }}">
                {{ $package->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        <p class="text-sm text-gray-500 mb-4 leading-relaxed line-clamp-2">{{ $package->description }}</p>
        <div class="flex gap-3 text-xs text-gray-500 mb-4">
            <span>⏱ {{ $package->duration_label }}</span>
            <span>📋 {{ $package->checklist_items_count }} item</span>
            <span>🗓 {{ $package->bookings_count }} booking</span>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.packages.edit', $package) }}" class="btn-secondary btn-sm flex-1 justify-center">Edit</a>
            <form method="POST" action="{{ route('admin.packages.destroy', $package) }}"
                  onsubmit="return confirm('Hapus paket ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger btn-sm px-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="md:col-span-3 text-center py-16 text-gray-400">
        Belum ada paket. <a href="{{ route('admin.packages.create') }}" class="text-blue-600 hover:underline">Tambah sekarang</a>
    </div>
    @endforelse
</div>
@endsection
