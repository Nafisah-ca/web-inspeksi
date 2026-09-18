@extends('layouts.admin')
@section('title', 'CMS Konten Website')
@section('page-title', 'CMS Konten Website')

@section('content')

<div class="mb-6">
    <p class="text-sm text-gray-500">
        Kelola semua teks, angka, dan konten yang tampil di halaman publik website.
        Klik section yang ingin diedit.
    </p>
</div>

<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
    @foreach($sections as $key => $label)
    @php
        $sectionItems = $contents[$key] ?? collect();
        $filled       = $sectionItems->filter(fn($i) => !empty($i->value))->count();
        $total        = $sectionItems->count();
        $pct          = $total > 0 ? round(($filled / $total) * 100) : 0;

        $icons = [
            'hero'    => ['bg-blue-100',   'text-blue-600',   'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
            'stats'   => ['bg-green-100',  'text-green-600',  'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            'why_us'  => ['bg-purple-100', 'text-purple-600', 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
            'how'     => ['bg-yellow-100', 'text-yellow-600', 'M13 10V3L4 14h7v7l9-11h-7z'],
            'cta'     => ['bg-red-100',    'text-red-600',    'M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122'],
            'contact' => ['bg-indigo-100', 'text-indigo-600', 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
            'footer'  => ['bg-gray-100',   'text-gray-600',   'M4 6h16M4 12h16M4 18h7'],
        ];
        [$bg, $tc, $path] = $icons[$key] ?? ['bg-gray-100', 'text-gray-600', 'M4 6h16M4 12h16M4 18h16'];
    @endphp

    <div class="card p-5 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $bg }} {{ $tc }} rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">{{ $label }}</h3>
                    <p class="text-xs text-gray-400">{{ $total }} field konten</p>
                </div>
            </div>
        </div>

        {{-- Progress kelengkapan isi --}}
        <div class="mb-4">
            <div class="flex justify-between text-xs text-gray-500 mb-1">
                <span>Terisi</span>
                <span>{{ $filled }}/{{ $total }} field</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="h-1.5 rounded-full transition-all {{ $pct === 100 ? 'bg-green-500' : ($pct > 50 ? 'bg-blue-500' : 'bg-yellow-400') }}"
                     style="width: {{ $pct }}%"></div>
            </div>
        </div>

        {{-- Preview isi --}}
        @if($sectionItems->isNotEmpty())
        <div class="bg-gray-50 rounded-xl p-3 mb-4 space-y-1">
            @foreach($sectionItems->take(2) as $item)
            <div class="flex gap-2 text-xs">
                <span class="text-gray-400 shrink-0 w-24 truncate">{{ $item->label }}</span>
                <span class="text-gray-600 truncate">{{ $item->value ?: '—' }}</span>
            </div>
            @endforeach
            @if($sectionItems->count() > 2)
            <p class="text-xs text-gray-400">+{{ $sectionItems->count() - 2 }} field lainnya</p>
            @endif
        </div>
        @endif

        <a href="{{ route('admin.site-content.edit', $key) }}"
           class="btn-primary w-full justify-center btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Konten
        </a>
    </div>
    @endforeach
</div>

{{-- Info --}}
<div class="mt-8 bg-blue-50 border border-blue-100 rounded-2xl p-5">
    <div class="flex gap-3">
        <svg class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="text-sm text-blue-700">
            <p class="font-semibold mb-1">Tentang CMS Konten</p>
            <p class="leading-relaxed">
                Semua teks yang tampil di halaman publik website (landing page, paket, footer, dll)
                diambil dari sini. Perubahan langsung tampil di website tanpa perlu deploy ulang.
                Paket inspeksi dikelola terpisah di menu <strong>Paket Inspeksi</strong>.
            </p>
        </div>
    </div>
</div>

@endsection
