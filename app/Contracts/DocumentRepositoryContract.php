<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\Document\StoreRequest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface DocumentRepositoryContract
{
    public function store(StoreRequest $request): void;

    public function searchForAdmin(string $search, User $user): Collection;

    public function searchForUser(string $search, User $user): Collection;
}
