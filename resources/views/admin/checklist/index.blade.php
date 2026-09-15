@extends('layouts.admin')
@section('title', 'Item Checklist')
@section('page-title', 'Kelola Item Checklist')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">

    {{-- Add form --}}
    <div class="card p-5">
        <h2 class="font-semibold text-gray-900 mb-4">Tambah Item Baru</h2>
        <form method="POST" action="{{ route('admin.checklist.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Paket <span class="text-red-500">*</span></label>
                <select name="package_id" class="form-input @error('package_id') border-red-300 @enderror" required>
                    <option value="">Pilih Paket</option>
                    @foreach($packages as $pkg)
                    <option value="{{ $pkg->id }}" {{ old('package_id') == $pkg->id ? 'selected' : '' }}>
                        {{ $pkg->name }}
                    </option>
                    @endforeach
                </select>
                @error('package_id') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="category" value="{{ old('category') }}"
                       class="form-input @error('category') border-red-300 @enderror"
                       placeholder="mis. Mesin, Rem, Ban..." list="categories" required>
                <datalist id="categories">
                    <option value="Mesin"><option value="Rem"><option value="Ban">
                    <option value="Transmisi"><option value="Kelistrikan"><option value="AC">
                    <option value="Kaki-Kaki"><option value="Body & Cat"><option value="Interior">
                    <option value="Kolong"><option value="Diagnostik">
                </datalist>
                @error('category') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Nama Item <span class="text-red-500">*</span></label>
                <input type="text" name="item_name" value="{{ old('item_name') }}"
                       class="form-input @error('item_name') border-red-300 @enderror"
                       placeholder="mis. Kampas Rem Depan" required>
                @error('item_name') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="form-input" min="0">
            </div>
            <button type="submit" class="btn-primary w-full justify-center">Tambah Item</button>
        </form>
    </div>

    {{-- Items list --}}
    <div class="lg:col-span-2 space-y-5">
        @foreach($packages as $package)
        <div class="card overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $package->name }}</h3>
                    <p class="text-xs text-gray-400">{{ $package->checklistItems->count() }} item</p>
                </div>
            </div>

            @if($package->checklistItems->isEmpty())
            <p class="px-5 py-4 text-sm text-gray-400">Belum ada item untuk paket ini.</p>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($package->checklistItems->groupBy('category') as $category => $items)
                <div class="px-5 py-3">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">{{ $category }}</p>
                    @foreach($items as $item)
                    <div class="flex items-center gap-3 py-1.5 group"
                         x-data="{ editing: false }">
                        <span class="text-gray-400 text-xs w-5">{{ $item->sort_order }}</span>

                        <div x-show="!editing" class="flex-1 text-sm text-gray-700">{{ $item->item_name }}</div>

                        <form x-show="editing" method="POST"
                              action="{{ route('admin.checklist.update', $item) }}"
                              class="flex-1 flex gap-2 items-center">
                            @csrf @method('PUT')
                            <input type="text" name="item_name" value="{{ $item->item_name }}"
                                   class="form-input text-xs py-1 flex-1">
                            <input type="text" name="category" value="{{ $item->category }}"
                                   class="form-input text-xs py-1 w-28">
                            <input type="number" name="sort_order" value="{{ $item->sort_order }}"
                                   class="form-input text-xs py-1 w-14">
                            <button type="submit" class="text-green-600 hover:text-green-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </form>

                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editing = !editing" class="text-blue-500 hover:text-blue-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('admin.checklist.destroy', $item) }}"
                                  onsubmit="return confirm('Hapus item ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
