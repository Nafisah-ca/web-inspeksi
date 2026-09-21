@extends('layouts.admin')
@section('title', 'Buat Booking')
@section('page-title', 'Buat Booking')
@section('breadcrumb')
    <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-700">Semua Booking</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-gray-900">Buat Booking</span>
@endsection

@section('content')
<div class="max-w-3xl">
    <div class="card p-6">
        <p class="text-sm text-gray-500 mb-6">
            Buat booking baru atas nama pelanggan. Booking akan masuk ke sistem dengan status
            <span class="font-semibold text-yellow-600">Menunggu Konfirmasi</span> dan mengikuti alur yang sama seperti booking dari website.
        </p>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
            <p class="text-sm font-semibold text-red-700 mb-1">Terdapat kesalahan pada form:</p>
            <ul class="text-sm text-red-600 space-y-0.5 list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.bookings.store') }}"
              x-data="bookingForm()" x-init="init()">
            @csrf

            <div class="space-y-5">

                {{-- ==================== SECTION 1: DATA PELANGGAN ==================== --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                        Data Pelanggan
                    </h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="form-label">Pelanggan <span class="text-red-500">*</span></label>
                            <select name="user_id" class="form-input" required
                                    x-model="selectedCustomer"
                                    @change="loadVehicles()">
                                <option value="">— Pilih Pelanggan —</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                    @if($customer->phone) · {{ $customer->phone }} @endif
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="form-label">Kendaraan <span class="text-red-500">*</span></label>
                            <select name="vehicle_id" class="form-input" required
                                    x-model="selectedVehicle"
                                    :disabled="!selectedCustomer || loadingVehicles">
                                <option value="">
                                    <span x-text="loadingVehicles ? 'Memuat kendaraan...' : (selectedCustomer ? '— Pilih Kendaraan —' : '— Pilih pelanggan terlebih dahulu —')"></span>
                                </option>
                                <template x-for="v in vehicles" :key="v.id">
                                    <option :value="v.id"
                                            :selected="v.id == {{ old('vehicle_id', 0) }}"
                                            x-text="v.year + ' ' + v.brand + ' ' + v.model + ' · ' + v.plate_number">
                                    </option>
                                </template>
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Kendaraan yang tampil hanya milik pelanggan yang dipilih.</p>
                            @error('vehicle_id')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- ==================== SECTION 2: PAKET & JADWAL ==================== --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        Paket & Jadwal
                    </h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="form-label">Paket Inspeksi <span class="text-red-500">*</span></label>
                            <select name="package_id" class="form-input" required
                                    x-model="selectedPackage"
                                    @change="updatePackageInfo()">
                                <option value="">— Pilih Paket —</option>
                                @foreach($packages as $package)
                                <option value="{{ $package->id }}"
                                    data-price="{{ $package->formatted_price }}"
                                    data-duration="{{ $package->duration_label }}"
                                    {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }} — {{ $package->formatted_price }}
                                </option>
                                @endforeach
                            </select>
                            <div x-show="packageInfo" class="mt-2 bg-blue-50 rounded-lg px-3 py-2 flex items-center gap-4 text-sm">
                                <span class="text-blue-700 font-semibold" x-text="packageInfo.price"></span>
                                <span class="text-gray-500 text-xs" x-text="packageInfo.duration"></span>
                            </div>
                            @error('package_id')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Tanggal Booking <span class="text-red-500">*</span></label>
                            <input type="date" name="booking_date" class="form-input" required
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('booking_date', date('Y-m-d')) }}">
                            @error('booking_date')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Waktu Booking <span class="text-red-500">*</span></label>
                            <select name="booking_time" class="form-input" required>
                                <option value="">— Pilih Waktu —</option>
                                @foreach(['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00'] as $time)
                                <option value="{{ $time }}" {{ old('booking_time') == $time ? 'selected' : '' }}>
                                    {{ $time }} WIB
                                </option>
                                @endforeach
                            </select>
                            @error('booking_time')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- ==================== SECTION 3: INSPEKTOR & CATATAN ==================== --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                        Inspektor & Catatan
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Inspektor <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <select name="inspector_id" class="form-input">
                                <option value="">— Belum ditentukan —</option>
                                @foreach($inspectors as $inspector)
                                <option value="{{ $inspector->id }}" {{ old('inspector_id') == $inspector->id ? 'selected' : '' }}>
                                    {{ $inspector->name }}
                                </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Inspektor dapat di-assign setelah booking dikonfirmasi.</p>
                            @error('inspector_id')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Catatan / Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea name="notes" rows="3" class="form-input"
                                      placeholder="Catatan tambahan dari admin atau pelanggan...">{{ old('notes') }}</textarea>
                            @error('notes')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-gray-100">
                <a href="{{ route('admin.bookings.index') }}"
                   class="btn-secondary btn-sm px-5">Batal</a>
                <button type="submit"
                        class="btn-primary btn-sm px-6 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Buat Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function bookingForm() {
    return {
        selectedCustomer: '{{ old('user_id', '') }}',
        selectedVehicle:  '{{ old('vehicle_id', '') }}',
        selectedPackage:  '{{ old('package_id', '') }}',
        vehicles:         [],
        loadingVehicles:  false,
        packageInfo:      null,

        init() {
            if (this.selectedCustomer) {
                this.loadVehicles();
            }
            if (this.selectedPackage) {
                this.updatePackageInfo();
            }
        },

        loadVehicles() {
            if (!this.selectedCustomer) {
                this.vehicles = [];
                this.selectedVehicle = '';
                return;
            }
            this.loadingVehicles = true;
            this.vehicles = [];
            const prev = this.selectedVehicle;
            fetch(`{{ route('admin.bookings.vehicles') }}?user_id=${this.selectedCustomer}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                this.vehicles = data;
                // Pulihkan pilihan lama jika ada (saat old values setelah error)
                if (prev && data.find(v => v.id == prev)) {
                    this.selectedVehicle = prev;
                } else {
                    this.selectedVehicle = data.length === 1 ? data[0].id : '';
                }
            })
            .catch(() => { this.vehicles = []; })
            .finally(() => { this.loadingVehicles = false; });
        },

        updatePackageInfo() {
            if (!this.selectedPackage) {
                this.packageInfo = null;
                return;
            }
            const option = document.querySelector(`select[name="package_id"] option[value="${this.selectedPackage}"]`);
            if (option) {
                this.packageInfo = {
                    price:    option.dataset.price,
                    duration: option.dataset.duration,
                };
            }
        },
    };
}
</script>
@endpush
