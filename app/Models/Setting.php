<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'group',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Helper method to get setting value by key
    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }

        return match($setting->type) {
            'boolean' => (bool) $setting->value,
            'number' => (float) $setting->value,
            'json' => json_decode($setting->value, true),
            'image' => $setting->value ? Storage::url($setting->value) : $default,
            default => $setting->value ?? $default,
        };
    }

    // Helper method to set setting value
    public static function setValue($key, $value, $type = 'text')
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => match($type) {
                    'boolean' => $value ? '1' : '0',
                    'json' => json_encode($value),
                    default => $value,
                },
                'type' => $type
            ]
        );

        return $setting;
    }

    // Get all settings grouped by group
    public static function getGrouped()
    {
        return static::orderBy('group')->orderBy('sort_order')->get()->groupBy('group');
    }
}
