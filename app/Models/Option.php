<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model 
{

    protected $fillable = [
        'option_name',
        'option_value',
        'autoload',
    ];

    public static function updateByKey($key, $value)
    {
        $option = self::firstOrCreate(['option_name' => $key]);
        $option->option_value = $value;
        $option->save();
    }

    public static function getByKey($key, $default = null)
    {
        $option = self::where('option_name', $key)->first();
        return $option ? $option->option_value : $default;
    }

}