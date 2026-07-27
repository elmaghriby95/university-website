<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Support\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaController extends Controller
{
    public function siteLogo(): BinaryFileResponse
    {
        $path = Setting::get('site_logo');

        abort_if(! $path, 404);

        $fullPath = Media::fullPath($path);

        abort_if(! $fullPath || ! is_file($fullPath), 404);

        return response()->file($fullPath, [
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }

    public function file(string $path): BinaryFileResponse
    {
        $path = str_replace('\\', '/', urldecode($path));
        $path = ltrim($path, '/');

        // Prevent path traversal
        abort_if(str_contains($path, '..'), 404);

        // Only allow known upload locations (new + legacy)
        $allowed = str_starts_with($path, 'uploads/')
            || preg_match('#^(news|events|faculties|sliders|pages|settings)/#', $path);

        abort_if(! $allowed, 404);

        $fullPath = Media::fullPath($path);

        abort_if(! $fullPath || ! is_file($fullPath), 404);

        // Extra safety: resolved path must stay inside public/uploads or storage/app/public
        $real = realpath($fullPath);
        $uploadsRoot = realpath(public_path('uploads'));
        $storageRoot = realpath(storage_path('app/public'));

        $insideUploads = $uploadsRoot && $real && str_starts_with($real, $uploadsRoot);
        $insideStorage = $storageRoot && $real && str_starts_with($real, $storageRoot);

        abort_if(! $insideUploads && ! $insideStorage, 404);

        return response()->file($fullPath, [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
