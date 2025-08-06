<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'button_link',
        'button_secondary_text',
        'button_secondary_link',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        
        // Check if it's an external URL (starts with http:// or https://)
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Otherwise, it's a local file
        return asset('storage/' . $this->image);
    }

    // For compatibility with existing homepage code
    public function getNameAttribute()
    {
        return $this->title;
    }

    public function getExcerptAttribute()
    {
        return $this->description;
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->image_url;
    }

    public function getPermalinkAttribute()
    {
        return $this->button_link ?? '#';
    }
}