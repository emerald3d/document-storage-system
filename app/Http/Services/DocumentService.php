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

    public function search(string $search): LengthAwarePaginator {
        $search = '%'.$search.'%';
        $authors = User::where('name', 'like', $search)->get();

        $documents = Document
            ::where('name', 'like', $search)
            ->orWhere('created_at', 'like', $search)
            ->orWhere('file_name', 'like', $search); // Пусть будет тоже, хоть и необязательно)

        $authors->each(function ($author) use(&$documents) {
            $documents->union(Document::where('user_id', 'like', $author->id));
        });

        return $documents->sortable()->paginate(8);
    }
}
