@extends('layouts.admin')
@section('title', 'Tambah Paket')
@section('page-title', 'Tambah Paket Inspeksi')
@section('breadcrumb')
    <a href="{{ route('admin.packages.index') }}" class="hover:text-gray-700">Paket</a> / Tambah
@endsection

@section('content')
<div class="max-w-xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.packages.store') }}" class="space-y-5">
            @csrf
            @include('admin.packages._form')
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan Paket</button>
                <a href="{{ route('admin.packages.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
