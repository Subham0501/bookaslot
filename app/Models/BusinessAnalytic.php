<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessAnalytic extends Model
{
    protected $fillable = [
        'business_id', 'type', 'model_id', 'ip_address', 'user_agent', 'location'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
