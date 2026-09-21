<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InspectionChecklistItem;
use App\Models\InspectionPackage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ChecklistItemController extends Controller
{
    public function index(): View
    {
        $packages = InspectionPackage::with('checklistItems')->orderBy('name')->get();

        return view('admin.checklist.index', compact('packages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'package_id'  => ['required', 'exists:inspection_package,id'],
            'item_name'   => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        InspectionChecklistItem::create($validated);

        return back()->with('success', 'Item checklist berhasil ditambahkan.');
    }

    public function update(Request $request, InspectionChecklistItem $checklistItem): RedirectResponse
    {
        $validated = $request->validate([
            'item_name'  => ['required', 'string', 'max:255'],
            'category'   => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $checklistItem->update($validated);

        return back()->with('success', 'Item checklist berhasil diperbarui.');
    }

    public function destroy(InspectionChecklistItem $checklistItem): RedirectResponse
    {
        $checklistItem->delete();

        return back()->with('success', 'Item checklist berhasil dihapus.');
    }
}
