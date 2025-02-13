<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\FileRepositoryContract;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryContract
{
    public function getFileName($file): string
    {
        return $file->getClientOriginalName();
    }

    public function getFilePath($file, $userId): string
    {
        return $file->storePublicly("documents/$userId", 'public');
    }

    public function deleteOldFile(string $filePath): void
    {
        Storage::delete($filePath);
    }
}
