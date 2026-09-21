<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionResult extends Model
{
    use HasFactory;

    protected $table = 'inspection_result';

    protected $fillable = [
        'booking_id',
        'checklist_json',
        'condition_summary',
        'recommendation',
        'photos',
        'inspector_notes',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'checklist_json' => 'array',
            'photos'         => 'array',
            'completed_at'   => 'datetime',
        ];
    }

    public function getOkCountAttribute(): int
    {
        if (empty($this->checklist_json)) return 0;
        return count(array_filter($this->checklist_json, fn($i) => ($i['status'] ?? '') === 'ok'));
    }

    public function getWarningCountAttribute(): int
    {
        if (empty($this->checklist_json)) return 0;
        return count(array_filter($this->checklist_json, fn($i) => ($i['status'] ?? '') === 'warning'));
    }

    public function getBadCountAttribute(): int
    {
        if (empty($this->checklist_json)) return 0;
        return count(array_filter($this->checklist_json, fn($i) => ($i['status'] ?? '') === 'bad'));
    }

    // Relationships
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
