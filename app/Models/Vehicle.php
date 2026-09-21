<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicle';

    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'plate_number',
        'year',
        'type',
        'notes',
    ];

    public static array $types = [
        'sedan'      => 'Sedan',
        'suv'        => 'SUV',
        'mpv'        => 'MPV',
        'hatchback'  => 'Hatchback',
        'pickup'     => 'Pickup',
        'truck'      => 'Truk',
        'motorcycle' => 'Motor',
        'other'      => 'Lainnya',
    ];

    public function getTypeLabel(): string
    {
        return self::$types[$this->type] ?? $this->type;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->year} {$this->brand} {$this->model}";
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
