<?php 

namespace App\Models;

class Regency extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'name',
        'alt_name',
        'province_id',
        'latitude',
        'longitude',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public static function getByProvinceId($provinceId)
    {
        return self::where('province_id', $provinceId)->get();
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' (' . $this->alt_name . ')';
    }

    public function getRelationNameAttribute()
    {
        return $this->province->name . ' - ' . $this->name;
    }
}