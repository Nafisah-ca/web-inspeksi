<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteContentController extends Controller
{
    /**
     * Daftar section yang bisa dikelola + label display-nya.
     */
    public static array $sections = [
        'hero'    => 'Hero / Banner Utama',
        'stats'   => 'Statistik (Angka-angka)',
        'why_us'  => 'Keunggulan Kami',
        'how'     => 'Cara Kerja',
        'cta'     => 'Call to Action (CTA)',
        'contact' => 'Kontak & Informasi',
        'footer'  => 'Footer',
    ];

    /**
     * Halaman utama CMS — tampilkan semua section sebagai tab.
     */
    public function index(): View
    {
        $sections  = self::$sections;
        $contents  = SiteContent::orderBy('section')->orderBy('sort_order')->get()->groupBy('section');

        return view('admin.site-content.index', compact('sections', 'contents'));
    }

    /**
     * Tampilkan form edit untuk satu section.
     */
    public function edit(string $section): View
    {
        abort_unless(array_key_exists($section, self::$sections), 404);

        $sectionLabel = self::$sections[$section];
        $items        = SiteContent::where('section', $section)
                            ->orderBy('sort_order')
                            ->get();

        return view('admin.site-content.edit', compact('section', 'sectionLabel', 'items'));
    }

    /**
     * Simpan perubahan konten satu section.
     */
    public function update(Request $request, string $section): RedirectResponse
    {
        abort_unless(array_key_exists($section, self::$sections), 404);

        $data = $request->input('content', []);

        foreach ($data as $key => $value) {
            SiteContent::where('section', $section)
                ->where('key', $key)
                ->update(['value' => $value]);
        }

        // Flush cache supaya perubahan langsung tampil
        SiteContent::flushCache();

        return redirect()->route('admin.site-content.edit', $section)
            ->with('success', 'Konten "' . self::$sections[$section] . '" berhasil diperbarui.');
    }
}
