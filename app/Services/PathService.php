<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PathService
{
    public const PUBLIC_DISK = 'public';

    public static function getUrl(string $filename, string $type): string
    {
        return Storage::disk(self::PUBLIC_DISK)->url($type . '/' . $filename);
    }

    /**
     * @return string
     */
    public static function getDefaultImage(): string
    {
        return Storage::disk(self::PUBLIC_DISK)->url('/default.jpg');
    }
}
