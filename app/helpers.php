<?php

use App\Support\Media;

if (! function_exists('media_url')) {
    function media_url(?string $path): ?string
    {
        return Media::url($path);
    }
}
