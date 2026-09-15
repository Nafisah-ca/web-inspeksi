<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'item_name',
        'category',
        'sort_order',
    ];

    // Relationships
    public function package(): BelongsTo
    {
        return $this->belongsTo(InspectionPackage::class, 'package_id');
    }
}
