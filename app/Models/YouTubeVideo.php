<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YouTubeVideo extends Model
{
    use HasFactory;

    protected $table = 'youtube_videos';

    protected $fillable = [
        'title',
        'description',
        'youtube_id',
        'thumbnail',
        'views_count',
        'published_date',
        'sort_order',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_date' => 'date'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getYoutubeUrlAttribute()
    {
        return 'https://www.youtube.com/watch?v=' . $this->youtube_id;
    }

    public function getEmbedUrlAttribute()
    {
        return 'https://www.youtube.com/embed/' . $this->youtube_id;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        // Auto-generate thumbnail from YouTube
        return 'https://img.youtube.com/vi/' . $this->youtube_id . '/maxresdefault.jpg';
    }

    public function getDurationFormattedAttribute()
    {
        // This would require YouTube API integration
        return '0:00';
    }

    public function getViewsFormattedAttribute()
    {
        if ($this->views_count >= 1000000) {
            return number_format($this->views_count / 1000000, 1) . 'M';
        } elseif ($this->views_count >= 1000) {
            return number_format($this->views_count / 1000, 1) . 'K';
        }
        
        return number_format($this->views_count);
    }

    public function getPublishedDateFormattedAttribute()
    {
        if (!$this->published_date) {
            return 'Belum dipublikasi';
        }
        
        $days = now()->diffInDays($this->published_date);
        
        if ($days == 0) {
            return 'Hari ini';
        } elseif ($days == 1) {
            return '1 hari yang lalu';
        } elseif ($days < 30) {
            return $days . ' hari yang lalu';
        } elseif ($days < 365) {
            $months = floor($days / 30);
            return $months . ' bulan yang lalu';
        } else {
            $years = floor($days / 365);
            return $years . ' tahun yang lalu';
        }
    }
}