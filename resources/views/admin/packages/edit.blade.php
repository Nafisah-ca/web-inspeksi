@extends('layouts.admin')
@section('title', 'Edit Paket')
@section('page-title', 'Edit Paket Inspeksi')
@section('breadcrumb')
    <a href="{{ route('admin.packages.index') }}" class="hover:text-gray-700">Paket</a> / Edit
@endsection

@section('content')
<div class="max-w-xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.packages.update', $package) }}" class="space-y-5">
            @csrf @method('PUT')
            @include('admin.packages._form', ['package' => $package])
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Perbarui Paket</button>
                <a href="{{ route('admin.packages.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
