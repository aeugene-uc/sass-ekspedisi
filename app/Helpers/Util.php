<?php

use Illuminate\Support\Facades\Storage;

function imageToBase64($file): ?string {
    try {
        return base64_encode(file_get_contents($file->getRealPath()));
    } catch (\Exception $e) {
        return null;
    }
}

function base64ToImage(string $base64, string $path, string $disk = 'public'): ?string {
    try {
        $image = base64_decode($base64);
        if (!$image) return null;
        Storage::disk($disk)->put($path, $image);
        return $path;
    } catch (\Exception $e) {
        return null;
    }
}