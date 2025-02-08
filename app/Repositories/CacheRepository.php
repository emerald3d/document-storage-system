<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\CacheRepositoryContract;

class CacheRepository implements CacheRepositoryContract
{
    public function setUserInfo(int $userId, array|Fluent $userData): void
    {

    }

    public function getUserInfo(int $userId): array
    {
        return [];
    }

    public function dropUserInfo(int $userId): void
    {

    }
}
