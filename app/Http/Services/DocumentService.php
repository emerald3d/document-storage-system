<?php

namespace App\Http\Services;

use App\Http\Requests\Document\StoreRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentService
{
    public function store(StoreRequest $request): void {
        $userId = $request->user()->id;
        $file = $request->file('file');

        Document::create([
            'user_id' => $userId,
            'name' => $request->input('name'),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $file->storePublicly("documents/$userId", 'public'),
        ]);
    }

    public function search(string $search): ?LengthAwarePaginator {
        $search = '%'.$search.'%';
        $authors = User::where('name', 'like', $search)->get();
        $documents = Document
            ::where('name', 'like', $search)
            ->orWhere('created_at', 'like', $search)
            ->orWhere('file_name', 'like', $search) // Пусть будет тоже, хоть и необязательно)
            ->get();

        $authors->each(function ($author) use(&$documents) {
            $documents = $documents->concat($author->documents);
        });

        // Попытка собрать многие запросы к БД в один
        //if ($authors->isNotEmpty()) {
        //    $authorsDocs = Document::where('user_id', 'like', $authors[0]->id);
        //    $authors->each(function ($author) use(&$authorsDocs) {
        //        $authorsDocs->union(Document::where('user_id', 'like', $author->id));
        //    });
        //    $documents = $documents->concat($authorsDocs->get());
        //}

        if ($documents->isEmpty()) {
            return null;
        }

        return $documents->toQuery()->sortable()->paginate(8);
    }
}
