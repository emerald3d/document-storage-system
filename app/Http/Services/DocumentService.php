<?php

namespace App\Http\Services;

use App\Http\Requests\Document\StoreRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;

class DocumentService
{
    public function store(StoreRequest $request): void {
        $userId = $request->user()->id;
        $file = $request->file('file');

        $document = new Fluent([
            'user_id' => $userId,
            'name' => $request->input('name'),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $file->storePublicly("documents/$userId", 'public'),
        ]);

        Document::create($document->toArray());
    }

    public function search(string $search): LengthAwarePaginator {
        $search = '%'.$search.'%';
        $authors = User::where('name', 'like', $search)->get()->modelKeys();

        $documents = Document
            ::where('name', 'like', $search)
            ->orWhere('created_at', 'like', $search)
            ->orWhere('file_name', 'like', $search); // Пусть будет тоже, хоть и необязательно)

        foreach ($authors as $userId) {
            $documents->union(Document::where('user_id', 'like', $userId));
        }

        return $documents->sortable()->paginate(8);
    }
}
