@extends('layouts.admin')
@section('title', 'Tambah Inspektor')
@section('page-title', 'Tambah Inspektor')
@section('breadcrumb')
    <a href="{{ route('admin.inspectors.index') }}" class="hover:text-gray-700">Inspektor</a> / Tambah
@endsection

@section('content')
<div class="max-w-lg">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.inspectors.store') }}" class="space-y-5">
            @csrf
            @include('admin.inspectors._form')
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.inspectors.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
