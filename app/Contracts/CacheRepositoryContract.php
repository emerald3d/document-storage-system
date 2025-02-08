<?php
declare(strict_types=1);

namespace App\Contracts;

//реализуй сохранение информации о клиенте на 1 час и выводи список всех пользователей в кеше админу по методу /users/list
interface CacheRepositoryContract
{
    public function setUserInfo(int $userId, array|Fluent $userData): void;

    public function getUserInfo(int $userId): array;

    public function dropUserInfo(int $userId): void;
}
