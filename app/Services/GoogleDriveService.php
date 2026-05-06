<?php

namespace App\Services;

use App\Enum\GoogleDriveFolder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class GoogleDriveService
{
    protected $disk;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->disk = Storage::disk('google');
    }

    public function uploadFile(UploadedFile $file, GoogleDriveFolder $folder)
    {
        $path = $folder->value.'/'.$file->hashName();

        $uploaded = $this->disk->put($path, file_get_contents($file->getRealPath()));

        if (! $uploaded) {
            throw new RuntimeException('Failed to upload file to Google Drive.');
        }

        // Return the path for storage, not the URL
        return $path;
    }

    public function deleteFile(string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        return $this->disk->delete($path);
    }

    public function getFileUrl(string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        return $this->disk->url($path);
    }
}
