<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return static::query()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    public static function logoFullPath(?string $path = null): ?string
    {
        return Media::fullPath($path ?? static::get('site_logo'));
    }

    public static function logoExists(?string $path = null): bool
    {
        return Media::exists($path ?? static::get('site_logo'));
    }

    public static function logoUrl(?string $path = null): ?string
    {
        return Media::url($path ?? static::get('site_logo'));
    }
}
