<?php
declare(strict_types=1);

namespace App\Contracts;

interface FileRepositoryContract
{
    public function getFileName($file): string;

    public function getFilePath($file, int $userId): string;

    public function deleteOldFile(string $filePath): void;
}
