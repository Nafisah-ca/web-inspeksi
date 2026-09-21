<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\InspectionPackage;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Request $request): View
    {
        $packages   = InspectionPackage::where('is_active', true)->get();
        $vehicles   = Auth::user()->vehicles;
        $selectedPackage = $request->query('package_id')
            ? InspectionPackage::find($request->query('package_id'))
            : null;

        return view('booking.create', compact('packages', 'vehicles', 'selectedPackage'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'package_id'   => ['required', 'exists:inspection_package,id'],
            'vehicle_type' => ['required', 'in:existing,new'],
            'vehicle_id'   => ['required_if:vehicle_type,existing', 'nullable', 'exists:vehicle,id'],
            // New vehicle fields
            'brand'        => ['required_if:vehicle_type,new', 'nullable', 'string', 'max:100'],
            'model'        => ['required_if:vehicle_type,new', 'nullable', 'string', 'max:100'],
            'plate_number' => ['required_if:vehicle_type,new', 'nullable', 'string', 'max:20'],
            'year'         => ['required_if:vehicle_type,new', 'nullable', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'type'         => ['required_if:vehicle_type,new', 'nullable', 'in:sedan,suv,mpv,hatchback,pickup,truck,motorcycle,other'],
            // Schedule
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'notes'        => ['nullable', 'string', 'max:1000'],
        ], [
            'package_id.required'   => 'Paket inspeksi wajib dipilih.',
            'booking_date.required' => 'Tanggal booking wajib diisi.',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'booking_time.required' => 'Waktu booking wajib dipilih.',
        ]);

        // Handle vehicle
        if ($validated['vehicle_type'] === 'new') {
            $vehicle = Vehicle::create([
                'user_id'      => Auth::id(),
                'brand'        => $validated['brand'],
                'model'        => $validated['model'],
                'plate_number' => $validated['plate_number'],
                'year'         => $validated['year'],
                'type'         => $validated['type'],
            ]);
            $vehicleId = $vehicle->id;
        } else {
            // Verify vehicle belongs to user
            $vehicle = Vehicle::where('id', $validated['vehicle_id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();
            $vehicleId = $vehicle->id;
        }

        // Check slot availability (max 5 bookings per time slot)
        $slotCount = Booking::where('booking_date', $validated['booking_date'])
            ->where('booking_time', $validated['booking_time'] . ':00')
            ->whereNotIn('status', ['cancelled'])
            ->count();

        if ($slotCount >= 5) {
            return back()->withErrors([
                'booking_time' => 'Slot waktu ini sudah penuh. Silakan pilih waktu lain.',
            ])->withInput();
        }

        $booking = Booking::create([
            'user_id'      => Auth::id(),
            'vehicle_id'   => $vehicleId,
            'package_id'   => $validated['package_id'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'] . ':00',
            'status'       => 'pending',
            'notes'        => $validated['notes'] ?? null,
        ]);

        return redirect()->route('booking.success', $booking)
            ->with('success', 'Booking berhasil dibuat! Kami akan segera mengkonfirmasi jadwal Anda.');
    }

    public function success(Booking $booking): View
    {
        // Ensure the booking belongs to authenticated user
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load(['vehicle', 'package']);

        return view('booking.success', compact('booking'));
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
        ]);

        $slots = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];

        $bookedCounts = Booking::where('booking_date', $request->date)
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('TIME_FORMAT(booking_time, "%H:%i") as slot, COUNT(*) as count')
            ->groupBy('slot')
            ->pluck('count', 'slot')
            ->toArray();

        $available = array_map(function ($slot) use ($bookedCounts) {
            return [
                'time'      => $slot,
                'available' => ($bookedCounts[$slot] ?? 0) < 5,
                'remaining' => 5 - ($bookedCounts[$slot] ?? 0),
            ];
        }, $slots);

        return response()->json($available);
    }
}
