<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Inspeksi — InspeksiKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 h-14 flex items-center gap-3">
        <a href="{{ route('inspector.dashboard') }}"
           class="text-gray-500 hover:text-gray-700 flex items-center gap-1 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Dashboard
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-sm font-semibold text-gray-900">Form Inspeksi</span>
        <span class="badge-{{ $booking->status_color }} ml-auto">{{ $booking->status_label }}</span>
    </div>
</nav>

<main class="max-w-4xl mx-auto px-4 sm:px-6 py-6">

    {{-- Booking info --}}
    <div class="card p-5 mb-5">
        <div class="grid sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase mb-2">Data Kendaraan</p>
                <p class="font-bold text-gray-900 text-base">{{ $booking->vehicle->year }} {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
                <p class="text-gray-600 font-mono">{{ $booking->vehicle->plate_number }}</p>
                <p class="text-gray-500">{{ $booking->vehicle->getTypeLabel() }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase mb-2">Info Booking</p>
                <p class="font-mono text-xs text-gray-500">{{ $booking->booking_code }}</p>
                <p class="text-gray-700 font-semibold">{{ $booking->user->name }}</p>
                <p class="text-gray-500">📅 {{ $booking->booking_date->format('d M Y') }} · {{ substr($booking->booking_time, 0, 5) }} WIB</p>
                <p class="text-blue-600 font-semibold">{{ $booking->package->name }}</p>
            </div>
        </div>
        @if($booking->notes)
        <div class="mt-3 bg-yellow-50 rounded-xl p-3">
            <p class="text-xs text-yellow-600 font-semibold mb-0.5">Catatan Customer</p>
            <p class="text-sm text-yellow-800">{{ $booking->notes }}</p>
        </div>
        @endif
    </div>

    {{-- Start button if confirmed --}}
    @if($booking->status === 'confirmed')
    <div class="card p-5 mb-5 text-center">
        <p class="text-gray-600 mb-3 text-sm">Mulai pengerjaan inspeksi untuk booking ini?</p>
        <form method="POST" action="{{ route('inspector.tasks.start', $booking) }}">
            @csrf
            <button type="submit" class="btn-primary">
                🔧 Mulai Inspeksi
            </button>
        </form>
    </div>
    @endif

    {{-- Inspection form --}}
    @if($booking->status === 'on_progress')
    <form method="POST" action="{{ route('inspector.tasks.result', $booking) }}"
          enctype="multipart/form-data"
          x-data="inspectionForm()">
        @csrf

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
            <p class="text-sm font-semibold text-red-700 mb-2">Ada kesalahan:</p>
            <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        {{-- Checklist by category --}}
        @foreach($booking->package->checklistItems->groupBy('category') as $category => $items)
        <div class="card p-5 mb-4">
            <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                {{ $category }}
            </h3>
            @foreach($items as $index => $item)
            @php $key = $category . '_' . $item->id; @endphp
            <input type="hidden" name="checklist[{{ $key }}][item_name]" value="{{ $item->item_name }}">
            <input type="hidden" name="checklist[{{ $key }}][category]"  value="{{ $item->category }}">

            <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-0 border-gray-100">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <p class="text-sm font-medium text-gray-800">{{ $item->item_name }}</p>

                    {{-- Status radio --}}
                    <div class="flex gap-1.5 shrink-0">
                        @foreach(['ok' => ['✅','green'], 'warning' => ['⚠️','yellow'], 'bad' => ['❌','red']] as $val => [$icon, $color])
                        <label class="cursor-pointer">
                            <input type="radio" name="checklist[{{ $key }}][status]"
                                   value="{{ $val }}" class="sr-only peer" required>
                            <div class="px-2.5 py-1 rounded-lg border-2 text-xs font-semibold transition-colors
                                        border-gray-200 text-gray-500
                                        peer-checked:border-{{ $color }}-500 peer-checked:bg-{{ $color }}-50 peer-checked:text-{{ $color }}-700">
                                {{ $icon }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <input type="text" name="checklist[{{ $key }}][note]"
                       class="form-input text-sm"
                       placeholder="Catatan (opsional)...">
            </div>
            @endforeach
        </div>
        @endforeach

        {{-- Summary & Recommendation --}}
        <div class="card p-5 mb-4">
            <h3 class="font-semibold text-gray-900 mb-4">Kesimpulan & Rekomendasi</h3>

            <div class="space-y-4">
                <div>
                    <label class="form-label">Ringkasan Kondisi Kendaraan <span class="text-red-500">*</span></label>
                    <textarea name="condition_summary" rows="3" required
                              class="form-input @error('condition_summary') border-red-300 @enderror"
                              placeholder="Deskripsikan kondisi keseluruhan kendaraan secara singkat...">{{ old('condition_summary') }}</textarea>
                    @error('condition_summary') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Rekomendasi Perbaikan <span class="text-red-500">*</span></label>
                    <textarea name="recommendation" rows="4" required
                              class="form-input @error('recommendation') border-red-300 @enderror"
                              placeholder="Tuliskan rekomendasi perbaikan secara berurutan...">{{ old('recommendation') }}</textarea>
                    @error('recommendation') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Catatan Internal Inspektor</label>
                    <textarea name="inspector_notes" rows="2"
                              class="form-input"
                              placeholder="Catatan internal (tidak ditampilkan ke customer)...">{{ old('inspector_notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Photo upload --}}
        <div class="card p-5 mb-5">
            <h3 class="font-semibold text-gray-900 mb-3">Foto Dokumentasi</h3>
            <p class="text-xs text-gray-500 mb-3">Upload foto kondisi kendaraan (maks. 5MB per foto)</p>
            <input type="file" name="photos[]" multiple accept="image/*"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold hover:file:bg-blue-100 file:cursor-pointer">
        </div>

        {{-- Submit --}}
        <div class="flex gap-3">
            <button type="submit"
                    onclick="return confirm('Selesaikan inspeksi dan kirim laporan ini?')"
                    class="btn-success flex-1 justify-center py-3 text-base font-bold">
                ✅ Selesaikan Inspeksi & Kirim Laporan
            </button>
            <a href="{{ route('inspector.dashboard') }}" class="btn-secondary px-5">Simpan Nanti</a>
        </div>
    </form>
    @endif

    {{-- Completed: show result --}}
    @if($booking->status === 'completed' && $booking->result)
    <div class="card p-5">
        <div class="text-center py-4">
            <div class="text-5xl mb-3">✅</div>
            <h2 class="text-xl font-bold text-gray-900 mb-1">Inspeksi Selesai</h2>
            <p class="text-gray-500 text-sm">Laporan sudah terkirim ke customer.</p>
            @if($booking->result->completed_at)
            <p class="text-xs text-gray-400 mt-1">{{ $booking->result->completed_at->format('d M Y, H:i') }}</p>
            @endif
        </div>

        <div class="grid grid-cols-3 gap-3 mt-4">
            <div class="bg-green-50 rounded-xl p-3 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $booking->result->ok_count }}</p>
                <p class="text-xs text-green-600">OK</p>
            </div>
            <div class="bg-yellow-50 rounded-xl p-3 text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $booking->result->warning_count }}</p>
                <p class="text-xs text-yellow-600">Perhatian</p>
            </div>
            <div class="bg-red-50 rounded-xl p-3 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $booking->result->bad_count }}</p>
                <p class="text-xs text-red-600">Bermasalah</p>
            </div>
        </div>
    </div>
    @endif

</main>

@push('scripts')
<script>
function inspectionForm() {
    return {};
}
</script>
@endpush

</body>
</html>
