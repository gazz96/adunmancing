<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

     public function getFeaturedImageUrlAttribute()
    {
        return $this->icon ? asset('storage/' . $this->icon) : null;
    }
}
