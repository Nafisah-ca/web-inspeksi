<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionPackage extends Model
{
    use HasFactory;

    protected $table = 'inspection_package';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_estimate',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price'     => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getDurationLabelAttribute(): string
    {
        $h = intdiv($this->duration_estimate, 60);
        $m = $this->duration_estimate % 60;
        if ($h > 0 && $m > 0) return "{$h} jam {$m} menit";
        if ($h > 0) return "{$h} jam";
        return "{$m} menit";
    }

    // Relationships
    public function checklistItems(): HasMany
    {
        return $this->hasMany(InspectionChecklistItem::class, 'package_id')->orderBy('sort_order');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'package_id');
    }
}
