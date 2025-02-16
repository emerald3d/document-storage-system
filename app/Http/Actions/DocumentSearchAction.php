<?php

declare(strict_types=1);

namespace App\Http\Actions;

use App\Contracts\DocumentRepositoryContract;
use App\Data\DocumentListData;

class DocumentSearchAction
{

    public function __construct(private readonly DocumentRepositoryContract $documentRepositoryContract)
    {

    }
    public function execute($user, $search): DocumentListData
    {
        $search = '%'.$search.'%';

        try {
            if ($user->isAdmin()) {
                $data = $this->documentRepositoryContract->searchForAdmin($search);
            } else {
                $data = $this->documentRepositoryContract->searchForUser($search);
            }
        } catch (\Throwable $e) {
            return DocumentListData::error($e);
        }

        return DocumentListData::success($data);

    }
}
