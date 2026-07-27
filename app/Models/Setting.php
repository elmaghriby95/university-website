<?php

namespace App\Models;

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
        $path = $path ?? static::get('site_logo');

        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'uploads/')) {
            return public_path($path);
        }

        return storage_path('app/public/'.$path);
    }

    public static function logoExists(?string $path = null): bool
    {
        $full = static::logoFullPath($path);

        return $full && is_file($full);
    }

    /**
     * Always serve via Laravel route so it works even if APP_URL / storage link is wrong.
     */
    public static function logoUrl(?string $path = null): ?string
    {
        $path = $path ?? static::get('site_logo');

        if (! $path || ! static::logoExists($path)) {
            return null;
        }

        $version = @filemtime(static::logoFullPath($path)) ?: time();

        return route('media.logo', ['v' => $version]);
    }
}
