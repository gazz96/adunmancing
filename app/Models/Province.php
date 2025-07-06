<?php 

namespace App\Models;

class Province extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'name',
        'alt_name',
        'latitude',
        'longitude',
    ];

    public static function getByCountryCode($countryCode)
    {
        return self::where('country_code', $countryCode)->get();
    }
}