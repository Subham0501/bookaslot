<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'gift_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'gift_price',
        'addons_total',
        'total_amount',
        'selected_addons',
        'status',
        'notes',
    ];

    protected $casts = [
        'gift_price' => 'decimal:2',
        'addons_total' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'selected_addons' => 'array',
    ];

    public function gift(): BelongsTo
    {
        return $this->belongsTo(Gift::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }
}
