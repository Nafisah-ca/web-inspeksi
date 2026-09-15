<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InspectionPackage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = InspectionPackage::withCount(['bookings', 'checklistItems'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('admin.packages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'price'             => ['required', 'numeric', 'min:0'],
            'duration_estimate' => ['required', 'integer', 'min:30'],
            'is_active'         => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        InspectionPackage::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket inspeksi berhasil ditambahkan.');
    }

    public function edit(InspectionPackage $package): View
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, InspectionPackage $package): RedirectResponse
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'price'             => ['required', 'numeric', 'min:0'],
            'duration_estimate' => ['required', 'integer', 'min:30'],
            'is_active'         => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket inspeksi berhasil diperbarui.');
    }

    public function destroy(InspectionPackage $package): RedirectResponse
    {
        if ($package->bookings()->whereNotIn('status', ['cancelled'])->exists()) {
            return back()->with('error', 'Paket tidak bisa dihapus karena masih ada booking aktif.');
        }

        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket inspeksi berhasil dihapus.');
    }
}
