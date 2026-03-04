<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomizedTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'template',
        'slug',
        'pin',
        'recipient_name',
        'status',
        'page_name',
        'heading',
        'subheading',
        'message',
        'from',
        'youtube_url',
        'memory_date',
        'heading_images',
        'section1_title',
        'section1_content',
        'section2_title',
        'section2_content',
        'section3_title',
        'section3_content',
        'section4_title',
        'section4_content',
        'section5_title',
        'section5_content',
        'theme_color',
        'bg_color',
        'bg_style',
        'images',
        'custom_fields',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'images' => 'array',
            'heading_images' => 'array',
            'custom_fields' => 'array',
            'memory_date' => 'date',
        ];
    }

    /**
     * Get the user that owns the customized template.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique slug from the heading or template name.
     */
    public static function generateSlug($heading, $userId, $template = null)
    {
        $baseSlug = Str::slug($heading ?: 'untitled-template');
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->where('user_id', $userId)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($template) {
            if (empty($template->slug)) {
                // Use page_name if available, otherwise fall back to heading
                $slugSource = $template->page_name ?? $template->heading ?? 'untitled-template';
                $template->slug = static::generateSlug($slugSource, $template->user_id, $template->template);
            }
        });
    }

    public function getProfileUrlAttribute()
    {
        $appUrl = config('app.url');
        $host = parse_url($appUrl, PHP_URL_HOST);
        $scheme = parse_url($appUrl, PHP_URL_SCHEME) ?? 'https';
        
        if (!$host || $host === 'localhost') {
            return url($this->slug); // Fallback for localhost
        }

        return $scheme . '://' . $this->slug . '.' . $host;
    }
}
