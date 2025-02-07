<?php

namespace App\Http\Services;

use App\Http\Requests\Document\SearchRequest;
use App\Http\Requests\Document\StoreRequest;
use App\Models\Document;
use App\Models\User;
use http\QueryString;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentService
{
    public function store(StoreRequest $request): void {
        $userId = $request->user()->id;
        $name = $request->validated()['name'];
        $fileName = $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storePublicly("documents/$userId", 'public');

        Document::create([
            'user_id' => $userId,
            'name' => $name,
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);
    }

    public function search(SearchRequest $request): ?LengthAwarePaginator {
        $documents = Document::where('name', 'like', '%'.$request->input('search').'%')->get();
        $documentsDate = Document::where('created_at', 'like', '%'.$request->input('search').'%')->get();
        $users = User::where('name', 'like', '%'.$request->input('search').'%')->get();

        foreach ($users as $user) {
            foreach ($user->documents as $document) {
                $documents->push($document);
            }
        }

        foreach ($documentsDate as $document) {
            $documents->push($document);
        }

        $documents = $documents->unique();

        if ($documents->isEmpty()) {
            return null;
        }

        return $documents->unique()->toQuery()->sortable()->paginate(8);
    }
}
