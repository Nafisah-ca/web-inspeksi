@extends('layouts.app')
@section('title', 'Paket Inspeksi')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Paket Inspeksi</h1>
            <p class="text-gray-500 max-w-xl mx-auto">Pilih paket yang sesuai kebutuhan. Semua paket sudah termasuk laporan tertulis dan garansi kepuasan.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-16">
            @foreach($packages as $i => $package)
            <div class="card p-6 hover:shadow-lg transition-shadow flex flex-col relative {{ $i === 1 ? 'border-blue-500 border-2' : '' }}">
                @if($i === 1)
                    <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs font-bold px-4 py-1 rounded-full">⭐ Paling Populer</span>
                @endif

                <div class="mb-6">
                    <div class="{{ ['bg-green-100 text-green-600', 'bg-blue-100 text-blue-600', 'bg-purple-100 text-purple-600'][$i] }} w-12 h-12 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $package->name }}</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $package->description }}</p>
                </div>

                <div class="mb-6">
                    <div class="text-3xl font-extrabold text-gray-900">{{ $package->formatted_price }}</div>
                    <div class="text-sm text-gray-400 mt-1">⏱ Estimasi {{ $package->duration_label }}</div>
                </div>

                {{-- Checklist by category --}}
                @if($package->checklistItems->isNotEmpty())
                <div class="flex-1 mb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Yang diperiksa:</p>
                    @foreach($package->checklistItems->groupBy('category') as $category => $items)
                    <div class="mb-3">
                        <p class="text-xs font-semibold text-gray-700 mb-1.5">{{ $category }}</p>
                        @foreach($items->take(4) as $item)
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $item->item_name }}
                        </div>
                        @endforeach
                        @if($items->count() > 4)
                        <p class="text-xs text-gray-400 ml-6">+{{ $items->count() - 4 }} item lainnya</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <a href="{{ route('booking.create', ['package_id' => $package->id]) }}"
                   class="{{ $i === 1 ? 'btn-primary' : 'btn-secondary' }} w-full justify-center mt-auto">
                    Pilih Paket Ini
                </a>
            </div>
            @endforeach
        </div>

        {{-- Guarantee from CMS --}}
        @if(!empty($why_us['title']))
        <div class="card p-8 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-6">{{ $why_us['title'] }}</h3>
            <div class="grid md:grid-cols-3 gap-6">
                @for($w = 1; $w <= 3; $w++)
                @if(!empty($why_us["item{$w}_title"]))
                <div>
                    <div class="text-3xl mb-2">{{ $why_us["item{$w}_icon"] ?? '✅' }}</div>
                    <h4 class="font-semibold text-gray-900 mb-1">{{ $why_us["item{$w}_title"] }}</h4>
                    <p class="text-sm text-gray-500">{{ $why_us["item{$w}_desc"] ?? '' }}</p>
                </div>
                @endif
                @endfor
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
