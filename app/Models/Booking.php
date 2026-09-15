<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'vehicle_id',
        'package_id',
        'inspector_id',
        'booking_date',
        'booking_time',
        'status',
        'notes',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }

    public static array $statuses = [
        'pending'     => 'Menunggu Konfirmasi',
        'confirmed'   => 'Dikonfirmasi',
        'on_progress' => 'Sedang Dikerjakan',
        'completed'   => 'Selesai',
        'cancelled'   => 'Dibatalkan',
    ];

    public static array $statusColors = [
        'pending'     => 'yellow',
        'confirmed'   => 'blue',
        'on_progress' => 'indigo',
        'completed'   => 'green',
        'cancelled'   => 'red',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'INS-' . strtoupper(Str::random(8));
            }
        });
    }

    public function getStatusLabelAttribute(): string
    {
        return self::$statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::$statusColors[$this->status] ?? 'gray';
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->booking_date->translatedFormat('d F Y');
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(InspectionPackage::class, 'package_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function result(): HasOne
    {
        return $this->hasOne(InspectionResult::class);
    }
}
