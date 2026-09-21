<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class InspectorController extends Controller
{
    public function index(): View
    {
        $inspectors = User::where('role', 'inspector')
            ->withCount(['assignedBookings', 'assignedBookings as completed_count' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->orderBy('name')
            ->get();

        return view('admin.inspectors.index', compact('inspectors'));
    }

    public function create(): View
    {
        return view('admin.inspectors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:user,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => 'inspector',
        ]);

        return redirect()->route('admin.inspectors.index')
            ->with('success', 'Inspektor berhasil ditambahkan.');
    }

    public function edit(User $inspector): View
    {
        abort_if($inspector->role !== 'inspector', 404);

        return view('admin.inspectors.edit', compact('inspector'));
    }

    public function update(Request $request, User $inspector): RedirectResponse
    {
        abort_if($inspector->role !== 'inspector', 404);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:user,email,' . $inspector->id],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $inspector->update($data);

        return redirect()->route('admin.inspectors.index')
            ->with('success', 'Data inspektor berhasil diperbarui.');
    }

    public function destroy(User $inspector): RedirectResponse
    {
        abort_if($inspector->role !== 'inspector', 404);

        if ($inspector->assignedBookings()->whereNotIn('status', ['completed', 'cancelled'])->exists()) {
            return back()->with('error', 'Inspektor tidak bisa dihapus karena masih memiliki tugas aktif.');
        }

        $inspector->delete();

        return redirect()->route('admin.inspectors.index')
            ->with('success', 'Inspektor berhasil dihapus.');
    }
}
