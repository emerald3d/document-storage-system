<?php
declare(strict_types=1);

namespace App\Contracts;

interface FileRepositoryContract
{
    public function getFileName($file): string;

    public function getFilePath($file, $userId): string;
}
