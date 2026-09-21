<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\InspectionResult;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InspectionResultController extends Controller
{
    /**
     * Daftar semua hasil inspeksi yang sudah selesai.
     */
    public function index(Request $request): View
    {
        $query = InspectionResult::with(['booking.user', 'booking.vehicle', 'booking.package', 'booking.inspector'])
            ->orderByDesc('completed_at');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('booking', function ($q) use ($s) {
                $q->where('booking_code', 'like', "%{$s}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$s}%"))
                  ->orWhereHas('vehicle', fn($q) => $q->where('plate_number', 'like', "%{$s}%"));
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('completed_at', $request->date);
        }

        $results = $query->paginate(15)->withQueryString();

        return view('admin.results.index', compact('results'));
    }

    /**
     * Tampilkan form input hasil inspeksi untuk booking tertentu.
     */
    public function create(Booking $booking): View
    {
        abort_if(
            in_array($booking->status, ['pending', 'cancelled']),
            403,
            'Hasil inspeksi hanya dapat diinput untuk booking yang sudah dikonfirmasi atau sedang dikerjakan.'
        );

        $booking->load(['user', 'vehicle', 'package.checklistItems', 'inspector', 'result']);

        // Jika sudah ada result, redirect ke halaman show
        if ($booking->result) {
            return redirect()->route('admin.results.show', $booking)
                ->with('info', 'Hasil inspeksi sudah ada. Anda dapat melihatnya di bawah.');
        }

        // Kelompokkan checklist items per kategori
        $checklistByCategory = $booking->package->checklistItems
            ->groupBy('category');

        return view('admin.results.create', compact('booking', 'checklistByCategory'));
    }

    /**
     * Simpan hasil inspeksi ke database.
     */
    public function store(Request $request, Booking $booking): RedirectResponse
    {
        abort_if(
            in_array($booking->status, ['pending', 'cancelled']),
            403,
            'Tidak dapat menyimpan hasil inspeksi untuk booking ini.'
        );

        $validated = $request->validate([
            'checklist'                 => ['required', 'array', 'min:1'],
            'checklist.*.item_name'     => ['required', 'string', 'max:255'],
            'checklist.*.category'      => ['required', 'string', 'max:100'],
            'checklist.*.status'        => ['required', 'in:ok,warning,bad,na'],
            'checklist.*.note'          => ['nullable', 'string', 'max:500'],
            'condition_summary'         => ['required', 'string', 'max:2000'],
            'recommendation'            => ['required', 'string', 'max:2000'],
            'inspector_notes'           => ['nullable', 'string', 'max:2000'],
            // Ringkasan cepat
            'mesin_status'              => ['nullable', 'in:ok,warning,bad'],
            'suspensi_status'           => ['nullable', 'in:ok,warning,bad'],
            'transmisi_status'          => ['nullable', 'in:ok,warning,bad'],
            'ac_status'                 => ['nullable', 'in:ok,warning,bad'],
            'bebas_banjir'              => ['nullable', 'boolean'],
            'bebas_tabrakan'            => ['nullable', 'boolean'],
            // Kilometer & tahun
            'kilometer'                 => ['nullable', 'integer', 'min:0'],
        ]);

        // Bangun array checklist JSON
        $checklistJson = [];
        foreach ($validated['checklist'] as $item) {
            $checklistJson[] = [
                'item_name' => $item['item_name'],
                'category'  => $item['category'],
                'status'    => $item['status'],
                'note'      => $item['note'] ?? '',
            ];
        }

        // Ringkasan cepat (summary card atas)
        $summaryCard = [
            'mesin'         => $validated['mesin_status']    ?? 'ok',
            'suspensi'      => $validated['suspensi_status'] ?? 'ok',
            'transmisi'     => $validated['transmisi_status'] ?? 'ok',
            'ac'            => $validated['ac_status']       ?? 'ok',
            'bebas_banjir'  => (bool) ($validated['bebas_banjir']   ?? true),
            'bebas_tabrakan'=> (bool) ($validated['bebas_tabrakan'] ?? true),
        ];

        InspectionResult::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'checklist_json'    => $checklistJson,
                'condition_summary' => $validated['condition_summary'],
                'recommendation'    => $validated['recommendation'],
                'inspector_notes'   => $validated['inspector_notes'] ?? null,
                'photos'            => [],
                'completed_at'      => now(),
                // Simpan summary card & kilometer di inspector_notes sebagai JSON terpisah
                // (kita reuse kolom yang ada, tidak perlu migrasi baru)
            ]
        );

        // Simpan summary_card & kilometer ke dalam inspector_notes sebagai JSON prefix
        // agar tidak perlu migrasi baru
        $result = $booking->result()->first();
        $meta = json_encode([
            '__meta'         => true,
            'summary_card'   => $summaryCard,
            'kilometer'      => $validated['kilometer'] ?? null,
        ]);
        $notesRaw = ($validated['inspector_notes'] ?? '');
        $result->update([
            'inspector_notes' => '__META__' . $meta . '__ENDMETA__' . $notesRaw,
        ]);

        // Auto-update status booking jadi completed jika masih on_progress
        if ($booking->status === 'on_progress') {
            $booking->update(['status' => 'completed']);
        }

        return redirect()->route('admin.results.show', $booking)
            ->with('success', "Hasil inspeksi booking #{$booking->booking_code} berhasil disimpan.");
    }

    /**
     * Tampilkan laporan hasil inspeksi (view-only).
     */
    public function show(Booking $booking): View
    {
        $booking->load(['user', 'vehicle', 'package', 'inspector', 'result']);

        abort_if(! $booking->result, 404, 'Hasil inspeksi belum tersedia untuk booking ini.');

        $result = $booking->result;

        // Parse meta dari inspector_notes
        $summaryCard = [
            'mesin'          => 'ok',
            'suspensi'       => 'ok',
            'transmisi'      => 'ok',
            'ac'             => 'ok',
            'bebas_banjir'   => true,
            'bebas_tabrakan' => true,
        ];
        $kilometer       = null;
        $inspectorNotes  = $result->inspector_notes ?? '';

        if (str_starts_with($inspectorNotes, '__META__')) {
            $end = strpos($inspectorNotes, '__ENDMETA__');
            if ($end !== false) {
                $metaJson = substr($inspectorNotes, 8, $end - 8);
                $meta     = json_decode($metaJson, true);
                if ($meta && isset($meta['__meta'])) {
                    $summaryCard    = $meta['summary_card']  ?? $summaryCard;
                    $kilometer      = $meta['kilometer']     ?? null;
                    $inspectorNotes = substr($inspectorNotes, $end + 11);
                }
            }
        }

        // Kelompokkan checklist per kategori
        $checklistByCategory = collect($result->checklist_json ?? [])
            ->groupBy('category');

        return view('admin.results.show', compact(
            'booking', 'result', 'summaryCard', 'kilometer',
            'inspectorNotes', 'checklistByCategory'
        ));
    }
}
