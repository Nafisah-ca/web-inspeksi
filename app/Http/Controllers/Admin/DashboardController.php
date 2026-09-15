<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pending'     => Booking::where('status', 'pending')->count(),
            'confirmed'   => Booking::where('status', 'confirmed')->count(),
            'on_progress' => Booking::where('status', 'on_progress')->count(),
            'completed'   => Booking::where('status', 'completed')->count(),
            'cancelled'   => Booking::where('status', 'cancelled')->count(),
            'total'       => Booking::count(),
            'customers'   => User::where('role', 'customer')->count(),
            'inspectors'  => User::where('role', 'inspector')->count(),
        ];

        // Bookings hari ini
        $todayBookings = Booking::whereDate('booking_date', today())
            ->with(['user', 'vehicle', 'package', 'inspector'])
            ->orderBy('booking_time')
            ->get();

        // Booking terbaru
        $recentBookings = Booking::with(['user', 'vehicle', 'package'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Chart data: 7 hari terakhir
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartData[] = [
                'date'  => now()->subDays($i)->format('d/m'),
                'count' => Booking::whereDate('created_at', $date)->count(),
            ];
        }

        return view('admin.dashboard', compact('stats', 'todayBookings', 'recentBookings', 'chartData'));
    }
}
