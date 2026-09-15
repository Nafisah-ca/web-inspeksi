<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Booking::where('user_id', Auth::id())
            ->with(['vehicle', 'package', 'inspector', 'result'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('user.history', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load(['vehicle', 'package', 'inspector', 'result']);

        return view('user.booking-detail', compact('booking'));
    }

    public function cancel(Booking $booking): \Illuminate\Http\RedirectResponse
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if(!in_array($booking->status, ['pending', 'confirmed']), 403, 'Booking tidak bisa dibatalkan.');

        $booking->update([
            'status'              => 'cancelled',
            'cancellation_reason' => 'Dibatalkan oleh customer.',
        ]);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
