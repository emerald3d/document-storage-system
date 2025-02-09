<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\Document\StoreRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface DocumentRepositoryContract
{
    public function store(StoreRequest $request): void;

    public function search(string $search): LengthAwarePaginator;
}
