<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon'];

    protected $appends = [
        'featured_image_url',
        'image_url_with_placeholder'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->icon) {
            return null;
        }
        
        // Check if it's an external URL (starts with http:// or https://)
        if (filter_var($this->icon, FILTER_VALIDATE_URL)) {
            return $this->icon;
        }
        
        // Otherwise, it's a local file
        return asset('storage/' . $this->icon);
    }

    public function getImageUrlWithPlaceholderAttribute()
    {
        if ($this->featured_image_url) {
            return $this->featured_image_url;
        }
        
        // Return placeholder image from Unsplash related to fishing/marine category
        return 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80';
    }

    public function getIconUrlAttribute()
    {
        return $this->getFeaturedImageUrlAttribute();
    }

    public function hasImage()
    {
        return !empty($this->icon);
    }

    public function getPermalinkAttribute()
    {
        return url('product-category/' . $this->slug);
    }
}
