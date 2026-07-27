<?php

namespace App\Support;

use Illuminate\Support\Str;

class Slug
{
    public static function make(string $title): string
    {
        $slug = Str::slug($title);

        if ($slug !== '') {
            return $slug;
        }

        $slug = preg_replace('/\s+/u', '-', trim($title)) ?: '';
        $slug = preg_replace('/[^\p{L}\p{N}\-]+/u', '', $slug) ?: '';

        return $slug !== '' ? mb_strtolower($slug) : 'item-'.Str::lower(Str::random(8));
    }
}
