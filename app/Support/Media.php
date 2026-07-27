<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Media
{
    public static function store(UploadedFile $file, string $folder): string
    {
        $folder = trim($folder, '/');
        $directory = public_path('uploads/'.$folder);
        File::ensureDirectoryExists($directory);

        $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = Str::lower(Str::random(12)).'-'.time().'.'.$extension;
        $file->move($directory, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }

    public static function delete(?string $path): void
    {
        $full = static::fullPath($path);

        if ($full && is_file($full)) {
            @unlink($full);
        }
    }

    public static function fullPath(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $path = str_replace('\\', '/', ltrim($path, '/'));

        if (str_starts_with($path, 'uploads/')) {
            return public_path($path);
        }

        // Legacy storage paths like news/xxx.jpg
        return storage_path('app/public/'.$path);
    }

    public static function exists(?string $path): bool
    {
        $full = static::fullPath($path);

        return $full && is_file($full);
    }

    public static function url(?string $path): ?string
    {
        if (! $path || ! static::exists($path)) {
            return null;
        }

        $version = @filemtime(static::fullPath($path)) ?: time();

        return route('media.file', [
            'path' => $path,
            'v' => $version,
        ]);
    }
}
