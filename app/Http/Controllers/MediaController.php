<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaController extends Controller
{
    public function siteLogo(): BinaryFileResponse
    {
        $path = Setting::get('site_logo');

        abort_if(! $path, 404);

        $fullPath = Setting::logoFullPath($path);

        abort_if(! $fullPath || ! is_file($fullPath), 404);

        return response()->file($fullPath, [
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }
}
