@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-5">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Dipercaya 1,000+ pelanggan
                </span>
                <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-6">
                    Inspeksi Kendaraan<br>
                    <span class="text-blue-200">Profesional & Transparan</span>
                </h1>
                <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                    Ketahui kondisi kendaraan Anda sebelum membeli atau menjual. Tim inspektor bersertifikat kami siap memberikan laporan detail yang bisa Anda percaya.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('booking.create') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-bold px-7 py-3 rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Booking Sekarang
                    </a>
                    <a href="{{ route('packages') }}"
                       class="inline-flex items-center justify-center gap-2 border-2 border-white/50 text-white font-semibold px-7 py-3 rounded-xl hover:bg-white/10 transition-colors">
                        Lihat Paket
                    </a>
                </div>
            </div>
            <div class="hidden lg:flex justify-center">
                <div class="relative">
                    <div class="w-72 h-72 bg-white/10 rounded-3xl flex items-center justify-center">
                        <svg class="w-40 h-40 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    {{-- Floating cards --}}
                    <div class="absolute -top-4 -right-8 bg-white rounded-2xl shadow-xl p-4 min-w-[160px]">
                        <p class="text-xs text-gray-500 mb-1">Inspeksi Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">1,200+</p>
                    </div>
                    <div class="absolute -bottom-4 -left-8 bg-white rounded-2xl shadow-xl p-4 min-w-[160px]">
                        <p class="text-xs text-gray-500 mb-1">Inspektor Terlatih</p>
                        <p class="text-2xl font-bold text-gray-900">15+</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-100">
            @foreach([
                ['1,200+', 'Inspeksi Selesai', '🔧'],
                ['98%',    'Kepuasan Pelanggan', '⭐'],
                ['15+',    'Inspektor Terlatih', '👨‍🔧'],
                ['3',      'Paket Tersedia', '📦'],
            ] as [$val, $label, $icon])
            <div class="py-6 px-4 text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $icon }} {{ $val }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $label }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Packages --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Pilih Paket Inspeksi</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Tiga pilihan paket sesuai kebutuhan dan budget Anda. Setiap paket dilengkapi laporan tertulis.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($packages as $i => $package)
            <div class="card p-6 hover:shadow-md transition-shadow relative {{ $i === 1 ? 'border-blue-500 border-2 ring-4 ring-blue-50' : '' }}">
                @if($i === 1)
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                        <span class="bg-blue-600 text-white text-xs font-bold px-4 py-1 rounded-full">Paling Populer</span>
                    </div>
                @endif
                <div class="mb-4">
                    <div class="w-10 h-10 rounded-xl mb-3 flex items-center justify-center {{ ['bg-green-100 text-green-600', 'bg-blue-100 text-blue-600', 'bg-purple-100 text-purple-600'][$i] }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $package->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $package->description }}</p>
                </div>

                <div class="mb-6">
                    <span class="text-3xl font-extrabold text-gray-900">{{ $package->formatted_price }}</span>
                    <span class="text-gray-400 text-sm ml-1">/ inspeksi</span>
                    <p class="text-xs text-gray-400 mt-1">⏱ Estimasi {{ $package->duration_label }}</p>
                </div>

                <a href="{{ route('booking.create', ['package_id' => $package->id]) }}"
                   class="{{ $i === 1 ? 'btn-primary' : 'btn-secondary' }} w-full justify-center">
                    Pilih Paket Ini
                </a>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('packages') }}" class="text-blue-600 text-sm font-medium hover:underline">
                Lihat detail semua paket →
            </a>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Cara Kerja</h2>
            <p class="text-gray-500">Proses inspeksi yang mudah dalam 4 langkah</p>
        </div>

        <div class="grid md:grid-cols-4 gap-6">
            @foreach([
                ['1', 'Pilih Paket', 'Tentukan paket inspeksi sesuai kebutuhan Anda', 'bg-blue-600'],
                ['2', 'Booking Jadwal', 'Isi data kendaraan dan pilih tanggal & waktu yang tersedia', 'bg-indigo-600'],
                ['3', 'Inspeksi Dilakukan', 'Inspektor kami datang dan melakukan pengecekan menyeluruh', 'bg-violet-600'],
                ['4', 'Terima Laporan', 'Dapatkan laporan lengkap dengan foto dan rekomendasi', 'bg-purple-600'],
            ] as [$num, $title, $desc, $color])
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 {{ $color }} text-white text-xl font-bold rounded-2xl mb-4">
                    {{ $num }}
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-blue-600">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Siap Inspeksi Kendaraan Anda?</h2>
        <p class="text-blue-100 mb-8">Jangan biarkan masalah tersembunyi merogoh kantong Anda. Inspeksi sekarang, tenang berkendara!</p>
        <a href="{{ route('booking.create') }}"
           class="inline-flex items-center gap-2 bg-white text-blue-700 font-bold px-8 py-3.5 rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Booking Sekarang — Gratis!
        </a>
    </div>
</section>

@endsection
