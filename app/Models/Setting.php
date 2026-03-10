<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Setting extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    /**
     * Helper untuk mengambil nilai setting dengan cepat
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) return $default;

        if ($setting->type === 'array') {
            return json_decode($setting->value, true) ?: [];
        }

        return $setting->value;
    }
}