<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'featured_image', 'author_id', 'is_published', 'views'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_post_category');
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    public function getExcerptAttribute()
    {
         // Ambil isi konten (misal dari field `content`)
        $plainText = strip_tags($this->content);
        // Ambil 100 kata pertama
        return \Str::words($plainText, 20, '...');
    }

    public function getPermalinkAttribute()
    {
        return url('post/' . $this->slug);
    }

    // Scope for trending blogs
    public function scopeTrending(Builder $query)
    {
        return $query->orderBy('views', 'desc')
                     ->orderBy('created_at', 'desc'); // recent & popular
    }
}

