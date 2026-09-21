<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\InspectionPackage;
use App\Models\User;
use App\Models\Vehicle;
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

    public function create(): View
    {
        $customers  = User::where('role', 'customer')->orderBy('name')->get();
        $packages   = InspectionPackage::where('is_active', true)->orderBy('name')->get();
        $inspectors = User::where('role', 'inspector')->orderBy('name')->get();

        return view('admin.bookings.create', compact('customers', 'packages', 'inspectors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id'      => ['required', 'exists:user,id'],
            'vehicle_id'   => ['required', 'exists:vehicle,id'],
            'package_id'   => ['required', 'exists:inspection_package,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'string'],
            'inspector_id' => ['nullable', 'exists:user,id'],
            'notes'        => ['nullable', 'string', 'max:1000'],
        ]);

        // Pastikan vehicle memang milik customer yang dipilih
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        abort_if((int) $vehicle->user_id !== (int) $validated['user_id'], 422, 'Kendaraan tidak milik customer ini.');

        // Jika inspektor dipilih, pastikan role-nya benar
        if (!empty($validated['inspector_id'])) {
            $inspector = User::findOrFail($validated['inspector_id']);
            abort_if($inspector->role !== 'inspector', 400, 'User bukan inspektor.');
        }

        $booking = Booking::create([
            'user_id'      => $validated['user_id'],
            'vehicle_id'   => $validated['vehicle_id'],
            'package_id'   => $validated['package_id'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'inspector_id' => $validated['inspector_id'] ?? null,
            'status'       => 'pending',
            'notes'        => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', "Booking {$booking->booking_code} berhasil dibuat.");
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

    public function startService(Booking $booking): RedirectResponse
    {
        abort_if($booking->status !== 'confirmed', 400, 'Hanya booking yang sudah dikonfirmasi yang bisa dimulai.');

        $booking->update(['status' => 'on_progress']);

        return back()->with('success', "Booking #{$booking->booking_code} sedang dilayani.");
    }

    public function complete(Booking $booking): RedirectResponse
    {
        abort_if($booking->status !== 'on_progress', 400, 'Hanya booking yang sedang dilayani yang bisa diselesaikan.');

        $booking->update(['status' => 'completed']);

        return back()->with('success', "Booking #{$booking->booking_code} telah selesai.");
    }

    public function assignInspector(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'inspector_id' => ['required', 'exists:user,id'],
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
            'status'              => ['required', 'in:confirmed,on_progress,completed,cancelled'],
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update($validated);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_if(in_array($booking->status, ['completed', 'cancelled']), 400, 'Booking ini tidak dapat dibatalkan.');

        $validated = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update([
            'status'              => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'] ?? 'Dibatalkan oleh admin.',
        ]);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Ambil kendaraan milik customer tertentu (AJAX).
     */
    public function getVehiclesByCustomer(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['user_id' => ['required', 'exists:user,id']]);

        $vehicles = Vehicle::where('user_id', $request->user_id)
            ->orderBy('brand')
            ->get(['id', 'brand', 'model', 'year', 'plate_number']);

        return response()->json($vehicles);
    }
}
