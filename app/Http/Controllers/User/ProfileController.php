<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user     = Auth::user();
        $vehicles = $user->vehicles()->orderByDesc('created_at')->get();

        return view('user.profile', compact('user', 'vehicles'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'unique:user,email,' . $user->id],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        Auth::user()->update(['password' => Hash::make($validated['password'])]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    // Vehicle management
    public function storeVehicle(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand'        => ['required', 'string', 'max:100'],
            'model'        => ['required', 'string', 'max:100'],
            'plate_number' => ['required', 'string', 'max:20'],
            'year'         => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'type'         => ['required', 'in:sedan,suv,mpv,hatchback,pickup,truck,motorcycle,other'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ]);

        Auth::user()->vehicles()->create($validated);

        return back()->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function updateVehicle(Request $request, Vehicle $vehicle): RedirectResponse
    {
        abort_if($vehicle->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'brand'        => ['required', 'string', 'max:100'],
            'model'        => ['required', 'string', 'max:100'],
            'plate_number' => ['required', 'string', 'max:20'],
            'year'         => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'type'         => ['required', 'in:sedan,suv,mpv,hatchback,pickup,truck,motorcycle,other'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ]);

        $vehicle->update($validated);

        return back()->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroyVehicle(Vehicle $vehicle): RedirectResponse
    {
        abort_if($vehicle->user_id !== Auth::id(), 403);

        $vehicle->delete();

        return back()->with('success', 'Kendaraan berhasil dihapus.');
    }
}
