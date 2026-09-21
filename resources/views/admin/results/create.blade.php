@extends('layouts.admin')
@section('title', 'Input Hasil Inspeksi — ' . $booking->booking_code)
@section('page-title', 'Input Hasil Inspeksi')
@section('breadcrumb')
    <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-700">Semua Booking</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.bookings.show', $booking) }}" class="hover:text-gray-700">{{ $booking->booking_code }}</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-gray-900">Input Hasil Inspeksi</span>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.results.store', $booking) }}" x-data="resultForm()">
@csrf

{{-- Info Booking --}}
<div class="card p-4 mb-5 bg-blue-50 border border-blue-100">
    <div class="flex flex-wrap gap-4 items-center text-sm">
        <div>
            <span class="text-xs text-blue-400 font-semibold uppercase">Booking</span>
            <p class="font-mono font-bold text-blue-800">{{ $booking->booking_code }}</p>
        </div>
        <div>
            <span class="text-xs text-blue-400 font-semibold uppercase">Pelanggan</span>
            <p class="font-semibold text-blue-900">{{ $booking->user->name }}</p>
        </div>
        <div>
            <span class="text-xs text-blue-400 font-semibold uppercase">Kendaraan</span>
            <p class="font-semibold text-blue-900">{{ $booking->vehicle->year }} {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }} &middot; <span class="font-mono">{{ $booking->vehicle->plate_number }}</span></p>
        </div>
        <div>
            <span class="text-xs text-blue-400 font-semibold uppercase">Paket</span>
            <p class="font-semibold text-blue-900">{{ $booking->package->name }}</p>
        </div>
        @if($booking->inspector)
        <div>
            <span class="text-xs text-blue-400 font-semibold uppercase">Inspektor</span>
            <p class="font-semibold text-blue-900">{{ $booking->inspector->name }}</p>
        </div>
        @endif
    </div>
</div>

@if($errors->any())
<div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
    <p class="text-sm font-semibold text-red-700 mb-1">Terdapat kesalahan:</p>
    <ul class="text-sm text-red-600 list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<div class="grid lg:grid-cols-3 gap-6">

    {{-- ===== KOLOM KIRI: Checklist ===== --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- === SECTION 1: Ringkasan Cepat (Summary Card) === --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-1">Ringkasan Kondisi Utama</h3>
            <p class="text-xs text-gray-400 mb-4">Pilih kondisi untuk setiap sistem utama kendaraan.</p>

            {{-- Kilometer --}}
            <div class="mb-4">
                <label class="form-label">Kilometer Kendaraan Saat Ini</label>
                <input type="number" name="kilometer" class="form-input w-48"
                       min="0" placeholder="cth: 41402" value="{{ old('kilometer') }}">
            </div>

            {{-- Status Sistem --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                @foreach([
                    ['mesin_status',    'Mesin'],
                    ['suspensi_status', 'Suspensi'],
                    ['transmisi_status','Transmisi'],
                    ['ac_status',       'AC'],
                ] as [$field, $label])
                <div>
                    <p class="text-xs font-semibold text-gray-500 mb-1.5">{{ $label }}</p>
                    <div class="flex gap-1.5">
                        @foreach(['ok' => ['Baik','green'], 'warning' => ['Servis','yellow'], 'bad' => ['Ganti','red']] as $val => [$txt, $clr])
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="{{ $field }}" value="{{ $val }}"
                                   class="sr-only peer" {{ old($field, 'ok') === $val ? 'checked' : '' }}>
                            <span class="block text-center text-xs font-semibold py-1.5 rounded-lg border-2
                                peer-checked:border-{{ $clr }}-500 peer-checked:bg-{{ $clr }}-50 peer-checked:text-{{ $clr }}-700
                                border-gray-200 text-gray-500 hover:border-{{ $clr }}-300 transition-colors">
                                {{ $txt }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Bebas Banjir & Tabrakan --}}
            <div class="grid grid-cols-2 gap-3">
                @foreach([
                    ['bebas_banjir',   'Bebas Banjir'],
                    ['bebas_tabrakan', 'Bebas Tabrakan'],
                ] as [$field, $label])
                <div>
                    <p class="text-xs font-semibold text-gray-500 mb-1.5">{{ $label }}</p>
                    <div class="flex gap-2">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="{{ $field }}" value="1"
                                   class="sr-only peer" {{ old($field, '1') === '1' ? 'checked' : '' }}>
                            <span class="block text-center text-xs font-semibold py-1.5 rounded-lg border-2
                                peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700
                                border-gray-200 text-gray-500 hover:border-green-300 transition-colors">
                                Ya
                            </span>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="{{ $field }}" value="0"
                                   class="sr-only peer" {{ old($field) === '0' ? 'checked' : '' }}>
                            <span class="block text-center text-xs font-semibold py-1.5 rounded-lg border-2
                                peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700
                                border-gray-200 text-gray-500 hover:border-red-300 transition-colors">
                                Tidak
                            </span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- === SECTION 2: Checklist per Kategori === --}}
        @if($checklistByCategory->isEmpty())
        <div class="card p-6 text-center text-gray-400 text-sm">
            <p>Paket ini belum memiliki item checklist.</p>
            <a href="{{ route('admin.checklist.index') }}" class="text-blue-600 hover:underline mt-1 inline-block text-xs">Kelola Checklist →</a>
        </div>
        @else
        @foreach($checklistByCategory as $category => $items)
        <div class="card overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                <h3 class="font-semibold text-gray-800 text-sm">{{ $category }}</h3>
                <span class="ml-auto text-xs text-gray-400">{{ $items->count() }} item</span>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($items as $idx => $item)
                @php $key = $loop->parent->index * 100 + $loop->index; @endphp
                <input type="hidden" name="checklist[{{ $key }}][item_name]" value="{{ $item->item_name }}">
                <input type="hidden" name="checklist[{{ $key }}][category]"  value="{{ $item->category }}">
                <div class="px-5 py-3">
                    <div class="flex items-start gap-3 flex-wrap sm:flex-nowrap">
                        {{-- Nama item --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 font-medium">{{ $item->item_name }}</p>
                        </div>
                        {{-- Status radio --}}
                        <div class="flex gap-1.5 shrink-0">
                            @foreach(['ok' => ['Baik','green'], 'warning' => ['Perlu Servis','yellow'], 'bad' => ['Ganti','red'], 'na' => ['N/A','gray']] as $val => [$txt, $clr])
                            <label class="cursor-pointer">
                                <input type="radio" name="checklist[{{ $key }}][status]" value="{{ $val }}"
                                       class="sr-only peer" {{ old("checklist.{$key}.status", 'ok') === $val ? 'checked' : '' }}>
                                <span class="block text-center text-xs font-semibold px-2.5 py-1 rounded-lg border-2 whitespace-nowrap
                                    peer-checked:border-{{ $clr }}-500 peer-checked:bg-{{ $clr }}-50 peer-checked:text-{{ $clr }}-700
                                    border-gray-200 text-gray-400 hover:border-{{ $clr }}-300 transition-colors">
                                    {{ $txt }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    {{-- Catatan --}}
                    <div class="mt-2">
                        <input type="text" name="checklist[{{ $key }}][note]"
                               value="{{ old("checklist.{$key}.note") }}"
                               placeholder="Catatan (opsional)..."
                               class="w-full text-xs border border-gray-200 rounded-lg px-3 py-1.5 text-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-300">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif

        {{-- === SECTION 3: Catatan Tambahan Montir === --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-1 text-sm">Catatan Tambahan Montir</h3>
            <p class="text-xs text-gray-400 mb-3">Tulis temuan atau catatan lain yang tidak tercakup dalam checklist di atas.</p>
            <textarea name="inspector_notes" rows="5" class="form-input text-sm"
                      placeholder="- Unit tidak di tes jalan&#10;- Ada rembesan oli di mesin (cek ke bengkel)&#10;- Ganti aki&#10;- Kap mesin lecet">{{ old('inspector_notes') }}</textarea>
            @error('inspector_notes')<p class="form-error">{{ $message }}</p>@enderror
        </div>

    </div>

    {{-- ===== KOLOM KANAN: Ringkasan & Submit ===== --}}
    <div class="space-y-5">

        {{-- Counter status --}}
        <div class="card p-5" x-data="{
            get ok()      { return document.querySelectorAll('input[name*=\"[status]\"]:checked[value=\"ok\"]').length },
            get warning() { return document.querySelectorAll('input[name*=\"[status]\"]:checked[value=\"warning\"]').length },
            get bad()     { return document.querySelectorAll('input[name*=\"[status]\"]:checked[value=\"bad\"]').length },
        }">
            <h3 class="font-semibold text-gray-900 mb-3 text-sm">Ringkasan Checklist</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-1.5 text-green-700">
                        <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>Baik
                    </span>
                    <span class="font-bold text-green-700" x-text="document.querySelectorAll('input[name*=\'[status]\']:checked[value=\'ok\']').length"></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-1.5 text-yellow-700">
                        <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span>Perlu Servis
                    </span>
                    <span class="font-bold text-yellow-700" x-text="document.querySelectorAll('input[name*=\'[status]\']:checked[value=\'warning\']').length"></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-1.5 text-red-700">
                        <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>Perlu Ganti
                    </span>
                    <span class="font-bold text-red-700" x-text="document.querySelectorAll('input[name*=\'[status]\']:checked[value=\'bad\']').length"></span>
                </div>
            </div>
        </div>

        {{-- Ringkasan Kondisi --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-1 text-sm">Ringkasan Kondisi <span class="text-red-500">*</span></h3>
            <p class="text-xs text-gray-400 mb-2">Deskripsi umum kondisi kendaraan secara keseluruhan.</p>
            <textarea name="condition_summary" rows="4" required class="form-input text-sm"
                      placeholder="Kondisi kendaraan secara keseluruhan cukup baik. Mesin berfungsi normal namun terdapat rembesan oli. Beberapa item perlu perhatian...">{{ old('condition_summary') }}</textarea>
            @error('condition_summary')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        {{-- Rekomendasi --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-1 text-sm">Rekomendasi <span class="text-red-500">*</span></h3>
            <p class="text-xs text-gray-400 mb-2">Saran tindakan yang perlu dilakukan oleh pemilik kendaraan.</p>
            <textarea name="recommendation" rows="4" required class="form-input text-sm"
                      placeholder="Segera lakukan penggantian oli mesin dan aki. Periksa rembesan oli ke bengkel terdekat. Ganti ban depan kiri dan belakang kiri...">{{ old('recommendation') }}</textarea>
            @error('recommendation')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        {{-- Submit --}}
        <div class="space-y-2">
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Simpan Hasil Inspeksi
            </button>
            <a href="{{ route('admin.bookings.show', $booking) }}"
               class="w-full flex items-center justify-center text-sm text-gray-500 hover:text-gray-700 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                Kembali ke Detail Booking
            </a>
        </div>

        {{-- Info --}}
        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 text-xs text-yellow-700 space-y-1">
            <p class="font-semibold">Perhatian:</p>
            <p>Setelah disimpan, status booking akan otomatis berubah menjadi <strong>Selesai</strong> jika masih dalam status Sedang Dilayani.</p>
        </div>

    </div>
</div>

</form>
@endsection

@push('scripts')
<script>
function resultForm() {
    return {};
}
</script>
@endpush
