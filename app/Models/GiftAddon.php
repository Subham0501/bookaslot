<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftAddon extends Model
{
    protected $fillable = [
        'gift_id',
        'name',
        'description',
        'price',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function gift(): BelongsTo
    {
        return $this->belongsTo(Gift::class);
    }
}
