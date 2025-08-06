<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'featured_image', 
        'is_published', 'meta_title', 'meta_description'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return null;
        }
        
        // Check if it's an external URL (starts with http:// or https://)
        if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
            return $this->featured_image;
        }
        
        // Otherwise, it's a local file
        return asset('storage/' . $this->featured_image);
    }

    public function getPermalinkAttribute()
    {
        return route('page.show', $this->slug);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
