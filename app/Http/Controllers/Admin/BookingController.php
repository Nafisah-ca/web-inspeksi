<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Booking::with(['user', 'vehicle', 'package', 'inspector'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('vehicle', fn($q) => $q->where('plate_number', 'like', "%{$search}%"));
            });
        }

        $bookings   = $query->paginate(15)->withQueryString();
        $inspectors = User::where('role', 'inspector')->orderBy('name')->get();

        return view('admin.bookings.index', compact('bookings', 'inspectors'));
    }

    public function show(Booking $booking): View
    {
        $booking->load(['user', 'vehicle', 'package', 'inspector', 'result']);
        $inspectors = User::where('role', 'inspector')->orderBy('name')->get();

        return view('admin.bookings.show', compact('booking', 'inspectors'));
    }

    public function confirm(Booking $booking): RedirectResponse
    {
        abort_if($booking->status !== 'pending', 400, 'Hanya booking pending yang bisa dikonfirmasi.');

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', "Booking #{$booking->booking_code} berhasil dikonfirmasi.");
    }

    public function assignInspector(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'inspector_id' => ['required', 'exists:users,id'],
        ]);

        $inspector = User::findOrFail($validated['inspector_id']);
        abort_if($inspector->role !== 'inspector', 400, 'User bukan inspektor.');

        $booking->update([
            'inspector_id' => $validated['inspector_id'],
            'status'       => $booking->status === 'pending' ? 'confirmed' : $booking->status,
        ]);

        return back()->with('success', "Inspektor {$inspector->name} berhasil di-assign.");
    }

    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:confirmed,on_progress,completed,cancelled'],
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update($validated);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update([
            'status'              => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'] ?? 'Dibatalkan oleh admin.',
        ]);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
