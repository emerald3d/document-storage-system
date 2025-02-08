<?php

namespace App\Http\Services;

use App\Data\DocumentData;
use App\Http\Requests\Document\StoreRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;

class DocumentService
{
    public  function store(StoreRequest $request): void
    {
        Document::create(DocumentData::success($request)->toArray());
    }

    public function search(string $search): DocumentData|Collection
    {
        $search = '%'.$search.'%';
        //когда есть запросы в бд лучше оборачивать в try-catch т.к бд всегда отвалиться может
        try {
            $authors = User::where('name', 'like', $search)->get()->modelKeys();

            $documents = Document::where('name', 'like', $search) //чисто визуальнее красивее
            ->orWhere('created_at', 'like', $search)
                ->orWhere('file_name', 'like', $search); // Пусть будет тоже, хоть и необязательно)

            foreach ($authors as $userId) {
                $documents->union(Document::where('user_id', 'like', $userId));
            }
        } catch (\Throwable $e) {
            return DocumentData::error($e);
        }

        $result = collect();
        $documents = $documents->sortable()->paginate(8);
        $documents->each(function($document) use(&$result){
           $result->add(DocumentData::fromApi($document));
        });

        return $documents;
    }
}
