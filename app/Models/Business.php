<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'business_name', 'category', 'established_year', 'logo', 'description',
        'address', 'google_maps_link', 'phone', 'email', 'whatsapp_number',
        'show_call_button', 'show_email_button', 'show_whatsapp_button',
        'whatsapp_message_template', 'social_links', 'theme', 'primary_color',
        'font_style', 'layout', 'footer_about', 'copyright_text',
        'show_map_preview', 'plan', 'is_active'
    ];

    protected $casts = [
        'social_links' => 'array',
        'show_call_button' => 'boolean',
        'show_email_button' => 'boolean',
        'show_whatsapp_button' => 'boolean',
        'show_map_preview' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(ProductCategory::class)->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    public function banners(): HasMany
    {
        return $this->hasMany(BusinessBanner::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(BusinessAnalytic::class);
    }
}
