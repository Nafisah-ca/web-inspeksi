<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteContent extends Model
{
    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
        'label',
        'sort_order',
    ];

    /**
     * Ambil satu value berdasarkan section & key.
     * Gunakan cache agar tidak query tiap request.
     */
    public static function get(string $section, string $key, string $default = ''): string
    {
        $all = static::allCached();
        return $all[$section][$key] ?? $default;
    }

    /**
     * Ambil semua konten dalam satu section sebagai array key => value.
     */
    public static function section(string $section): array
    {
        $all = static::allCached();
        return $all[$section] ?? [];
    }

    /**
     * Ambil semua konten, dikelompokkan per section, dari cache.
     */
    public static function allCached(): array
    {
        return Cache::remember('site_contents', 60 * 60, function () {
            return static::all()
                ->groupBy('section')
                ->map(fn($items) => $items->pluck('value', 'key')->toArray())
                ->toArray();
        });
    }

    /**
     * Flush cache konten (dipanggil setelah update CMS).
     */
    public static function flushCache(): void
    {
        Cache::forget('site_contents');
    }
}
