<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Convert uploaded image to WebP format and store it
     *
     * @param UploadedFile $file The uploaded file
     * @param string $directory Target directory (e.g., 'avatars', 'thumbnails')
     * @param int $quality WebP quality (0-100, default 80)
     * @return string The stored file path
     */
    public function convertAndStore(UploadedFile $file, string $directory, int $quality = 80): string
    {
        // Generate unique filename with .webp extension
        $filename = uniqid() . '_' . time() . '.webp';
        $path = $directory . '/' . $filename;

        // Read and convert image to WebP
        $image = Image::read($file);
        $encoded = $image->toWebp($quality);

        // Store the WebP encoded image
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Delete an image from storage
     *
     * @param string|null $path The file path to delete
     * @return bool
     */
    public function delete(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }
}
