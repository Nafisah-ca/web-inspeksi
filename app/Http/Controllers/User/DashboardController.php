<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $activeBookings = Booking::where('user_id', $user->id)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with(['vehicle', 'package', 'inspector'])
            ->orderBy('booking_date')
            ->get();

        $recentCompleted = Booking::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->with(['vehicle', 'package'])
            ->orderByDesc('updated_at')
            ->limit(3)
            ->get();

        $stats = [
            'total'       => Booking::where('user_id', $user->id)->count(),
            'completed'   => Booking::where('user_id', $user->id)->where('status', 'completed')->count(),
            'pending'     => Booking::where('user_id', $user->id)->whereIn('status', ['pending', 'confirmed'])->count(),
            'on_progress' => Booking::where('user_id', $user->id)->where('status', 'on_progress')->count(),
        ];

        return view('user.dashboard', compact('activeBookings', 'recentCompleted', 'stats'));
    }
}
