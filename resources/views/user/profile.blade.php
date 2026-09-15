@extends('layouts.user')
@section('title', 'Profil Saya')

@section('content')

<h1 class="text-xl font-bold text-gray-900 mb-6">Profil Saya</h1>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- Left: Profile + Password --}}
    <div class="space-y-5">
        {{-- Profile --}}
        <div class="card p-5">
            <div class="flex items-center gap-4 mb-5">
                <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <span class="badge-blue mt-1">Customer</span>
                </div>
            </div>

            <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="form-input @error('name') border-red-300 @enderror" required>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="form-input @error('email') border-red-300 @enderror" required>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">No. HP / WhatsApp</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="form-input @error('phone') border-red-300 @enderror"
                           placeholder="08xxxxxxxxxx">
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-primary w-full justify-center">Simpan Profil</button>
            </form>
        </div>

        {{-- Change password --}}
        <div class="card p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Ubah Password</h2>
            <form method="POST" action="{{ route('user.profile.password') }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password"
                           class="form-input @error('current_password') border-red-300 @enderror" required>
                    @error('current_password') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password"
                           class="form-input @error('password') border-red-300 @enderror"
                           placeholder="Minimal 8 karakter" required>
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
                <button type="submit" class="btn-secondary w-full justify-center">Ubah Password</button>
            </form>
        </div>
    </div>

    {{-- Right: Vehicles --}}
    <div class="lg:col-span-2">
        <div class="card">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Kendaraan Saya</h2>
                <span class="badge-gray">{{ $vehicles->count() }} kendaraan</span>
            </div>

            {{-- Add vehicle --}}
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span x-text="open ? 'Tutup' : 'Tambah Kendaraan Baru'"></span>
                </button>
                <div x-show="open" x-transition class="mt-4">
                    <form method="POST" action="{{ route('user.vehicles.store') }}" class="space-y-4">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Merek</label>
                                <input type="text" name="brand" value="{{ old('brand') }}"
                                       class="form-input @error('brand') border-red-300 @enderror"
                                       placeholder="Toyota" required>
                                @error('brand') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Model</label>
                                <input type="text" name="model" value="{{ old('model') }}"
                                       class="form-input @error('model') border-red-300 @enderror"
                                       placeholder="Avanza" required>
                                @error('model') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">No. Plat</label>
                                <input type="text" name="plate_number" value="{{ old('plate_number') }}"
                                       class="form-input @error('plate_number') border-red-300 @enderror"
                                       placeholder="B 1234 ABC" required>
                                @error('plate_number') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Tahun</label>
                                <input type="number" name="year" value="{{ old('year') }}"
                                       class="form-input @error('year') border-red-300 @enderror"
                                       placeholder="{{ date('Y') }}" min="1990" max="{{ date('Y') + 1 }}" required>
                                @error('year') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label">Tipe Kendaraan</label>
                                <select name="type" class="form-input @error('type') border-red-300 @enderror" required>
                                    <option value="">Pilih tipe</option>
                                    @foreach(\App\Models\Vehicle::$types as $val => $label)
                                    <option value="{{ $val }}" {{ old('type') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="btn-primary btn-sm">Tambah Kendaraan</button>
                            <button type="button" @click="open = false" class="btn-secondary btn-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Vehicle list --}}
            @if($vehicles->isEmpty())
            <div class="px-5 py-10 text-center text-gray-400 text-sm">
                Belum ada kendaraan tersimpan.
            </div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($vehicles as $vehicle)
                <div class="px-5 py-4" x-data="{ editing: false }">
                    {{-- View mode --}}
                    <div x-show="!editing" class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">{{ $vehicle->year }} {{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                <p class="text-xs text-gray-500">{{ $vehicle->plate_number }} · {{ $vehicle->getTypeLabel() }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 shrink-0">
                            <button @click="editing = true" class="btn-secondary btn-sm">Edit</button>
                            <form method="POST" action="{{ route('user.vehicles.destroy', $vehicle) }}"
                                  onsubmit="return confirm('Hapus kendaraan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>

                    {{-- Edit mode --}}
                    <div x-show="editing" x-transition>
                        <form method="POST" action="{{ route('user.vehicles.update', $vehicle) }}" class="space-y-3">
                            @csrf @method('PUT')
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="form-label text-xs">Merek</label>
                                    <input type="text" name="brand" value="{{ $vehicle->brand }}" class="form-input text-sm" required>
                                </div>
                                <div>
                                    <label class="form-label text-xs">Model</label>
                                    <input type="text" name="model" value="{{ $vehicle->model }}" class="form-input text-sm" required>
                                </div>
                                <div>
                                    <label class="form-label text-xs">No. Plat</label>
                                    <input type="text" name="plate_number" value="{{ $vehicle->plate_number }}" class="form-input text-sm" required>
                                </div>
                                <div>
                                    <label class="form-label text-xs">Tahun</label>
                                    <input type="number" name="year" value="{{ $vehicle->year }}" class="form-input text-sm" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label text-xs">Tipe</label>
                                    <select name="type" class="form-input text-sm" required>
                                        @foreach(\App\Models\Vehicle::$types as $val => $label)
                                        <option value="{{ $val }}" {{ $vehicle->type == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="btn-primary btn-sm">Simpan</button>
                                <button type="button" @click="editing = false" class="btn-secondary btn-sm">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
