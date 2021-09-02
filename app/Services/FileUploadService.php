<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadFile($file, $prefix): string
    {
        $filePath = "uploads/{$prefix}";
        return Storage::disk('public')->put($filePath, $file);
    }

    public function removeFile($path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
