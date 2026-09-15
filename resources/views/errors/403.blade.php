@extends('layouts.app')
@section('title', 'Akses Ditolak')
@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <p class="text-6xl font-black text-gray-200 mb-4">403</p>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Akses Ditolak</h1>
        <p class="text-gray-500 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('home') }}" class="btn-primary">Kembali ke Beranda</a>
    </div>
</div>
@endsection
