@extends('layouts.admin')
@section('title', 'Edit Inspektor')
@section('page-title', 'Edit Inspektor')
@section('breadcrumb')
    <a href="{{ route('admin.inspectors.index') }}" class="hover:text-gray-700">Inspektor</a> / Edit
@endsection

@section('content')
<div class="max-w-lg">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.inspectors.update', $inspector) }}" class="space-y-5">
            @csrf @method('PUT')
            @include('admin.inspectors._form', ['inspector' => $inspector])
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Perbarui</button>
                <a href="{{ route('admin.inspectors.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
