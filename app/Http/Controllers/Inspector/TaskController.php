<?php

namespace App\Http\Controllers\Inspector;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\InspectionResult;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function dashboard(): View
    {
        $inspector = Auth::user();

        $activeTasks = Booking::where('inspector_id', $inspector->id)
            ->whereIn('status', ['confirmed', 'on_progress'])
            ->with(['user', 'vehicle', 'package'])
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->get();

        $completedTasks = Booking::where('inspector_id', $inspector->id)
            ->where('status', 'completed')
            ->with(['vehicle', 'package'])
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        $stats = [
            'total'       => Booking::where('inspector_id', $inspector->id)->count(),
            'on_progress' => Booking::where('inspector_id', $inspector->id)->where('status', 'on_progress')->count(),
            'completed'   => Booking::where('inspector_id', $inspector->id)->where('status', 'completed')->count(),
        ];

        return view('inspector.dashboard', compact('activeTasks', 'completedTasks', 'stats'));
    }

    public function show(Booking $booking): View
    {
        abort_if($booking->inspector_id !== Auth::id(), 403);

        $booking->load(['user', 'vehicle', 'package.checklistItems', 'result']);

        return view('inspector.task-detail', compact('booking'));
    }

    public function startWork(Booking $booking): RedirectResponse
    {
        abort_if($booking->inspector_id !== Auth::id(), 403);
        abort_if($booking->status !== 'confirmed', 400);

        $booking->update(['status' => 'on_progress']);

        return back()->with('success', 'Pengerjaan dimulai.');
    }

    public function submitResult(Request $request, Booking $booking): RedirectResponse
    {
        abort_if($booking->inspector_id !== Auth::id(), 403);
        abort_if($booking->status !== 'on_progress', 400, 'Booking harus dalam status on_progress.');

        $validated = $request->validate([
            'checklist'         => ['required', 'array'],
            'checklist.*.item_name' => ['required', 'string'],
            'checklist.*.category'  => ['required', 'string'],
            'checklist.*.status'    => ['required', 'in:ok,warning,bad'],
            'checklist.*.note'      => ['nullable', 'string', 'max:500'],
            'condition_summary' => ['required', 'string'],
            'recommendation'    => ['required', 'string'],
            'inspector_notes'   => ['nullable', 'string'],
            'photos.*'          => ['nullable', 'image', 'max:5120'],
        ]);

        // Handle photo uploads
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store("inspections/{$booking->id}", 'public');
                $photoPaths[] = $path;
            }
        }

        // Build checklist JSON
        $checklistJson = [];
        foreach ($validated['checklist'] as $item) {
            $checklistJson[] = [
                'item_name' => $item['item_name'],
                'category'  => $item['category'],
                'status'    => $item['status'],
                'note'      => $item['note'] ?? '',
            ];
        }

        // Update or create result
        InspectionResult::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'checklist_json'    => $checklistJson,
                'condition_summary' => $validated['condition_summary'],
                'recommendation'    => $validated['recommendation'],
                'inspector_notes'   => $validated['inspector_notes'] ?? null,
                'photos'            => $photoPaths,
                'completed_at'      => now(),
            ]
        );

        $booking->update(['status' => 'completed']);

        return redirect()->route('inspector.dashboard')
            ->with('success', "Inspeksi booking #{$booking->booking_code} berhasil diselesaikan.");
    }
}
