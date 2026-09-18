@extends('layouts.admin')
@section('title', 'Edit ' . $sectionLabel)
@section('page-title', 'Edit Konten: ' . $sectionLabel)
@section('breadcrumb')
    <a href="{{ route('admin.site-content.index') }}" class="hover:text-gray-700">CMS Konten</a>
    / {{ $sectionLabel }}
@endsection

@section('content')

<div class="max-w-3xl">

    {{-- Tab navigasi section lain --}}
    <div class="flex gap-2 flex-wrap mb-6">
        @foreach(\App\Http\Controllers\Admin\SiteContentController::$sections as $key => $label)
        <a href="{{ route('admin.site-content.edit', $key) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors
                  {{ $key === $section
                      ? 'bg-blue-600 text-white'
                      : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition class="mb-5">
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.site-content.update', $section) }}">
        @csrf @method('PUT')

        <div class="card p-6 space-y-5">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900">{{ $sectionLabel }}</h2>
                    <p class="text-xs text-gray-400">{{ $items->count() }} field • Perubahan langsung tampil di website</p>
                </div>
            </div>

            @forelse($items as $item)
            <div class="group">
                <label class="form-label flex items-center justify-between">
                    <span>{{ $item->label }}</span>
                    <span class="text-xs text-gray-300 font-normal font-mono">{{ $item->section }}.{{ $item->key }}</span>
                </label>

                @if($item->type === 'textarea')
                    <textarea
                        name="content[{{ $item->key }}]"
                        rows="4"
                        class="form-input"
                        placeholder="Kosongkan jika tidak ingin ditampilkan...">{{ old('content.' . $item->key, $item->value) }}</textarea>

                @elseif($item->type === 'image')
                    <div class="space-y-2">
                        <input type="url"
                               name="content[{{ $item->key }}]"
                               value="{{ old('content.' . $item->key, $item->value) }}"
                               class="form-input"
                               placeholder="https://...">
                        @if($item->value)
                        <div class="rounded-xl overflow-hidden w-32 h-20 bg-gray-100">
                            <img src="{{ $item->value }}" alt="Preview" class="w-full h-full object-cover"
                                 onerror="this.style.display='none'">
                        </div>
                        @endif
                    </div>

                @else {{-- text --}}
                    <input type="text"
                           name="content[{{ $item->key }}]"
                           value="{{ old('content.' . $item->key, $item->value) }}"
                           class="form-input"
                           placeholder="Kosongkan jika tidak ingin ditampilkan...">
                @endif

                {{-- Hint: dimana field ini dipakai --}}
                @if($item->type === 'textarea')
                <p class="text-xs text-gray-400 mt-1">💡 Field teks panjang — bisa gunakan baris baru untuk list.</p>
                @endif
            </div>
            @empty
            <div class="text-center py-8 text-gray-400">
                <p>Tidak ada field untuk section ini.</p>
            </div>
            @endforelse

            @if($items->isNotEmpty())
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('home') }}" target="_blank"
                   class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Preview Website
                </a>
            </div>
            @endif
        </div>
    </form>
</div>

@endsection
