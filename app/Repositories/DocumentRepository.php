<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Collection;
use App\Contracts\DocumentRepositoryContract;
use App\Data\DocumentData;
use App\Http\Requests\Document\StoreRequest;
use App\Http\Requests\Document\UpdateRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class DocumentRepository implements DocumentRepositoryContract
{
    public function store(StoreRequest $request): void
    {
        Document::create(DocumentData::success($request)->toArray());
    }

    public function update(UpdateRequest $request): void
    {
        // А тут и в create не надо try-catch, с бд же работа? Или оно автоматом проверяет
        $document = Document::find($request->getDocumentId());
        $data = DocumentData::update($request)->toArray();
        $document->update($data);
    }

    public function search(string $search, User $user): LengthAwarePaginator
    {
        $search = '%'.$search.'%';

        if ($user->isAdmin()) {
            // Когда есть запросы в бд лучше оборачивать в try-catch т.к бд всегда отвалиться может
            try {
                $authors = User::where('name', 'like', $search)->get()->modelKeys();

                $documents = Document::where('name', 'like', $search) // Чисто визуальнее красивее
                    ->orWhere('created_at', 'like', $search)
                    ->orWhere('file_name', 'like', $search); // Пусть будет тоже, хоть и необязательно)

                foreach ($authors as $authorUserId) {
                    $documents->union(Document::where('user_id', 'like', $authorUserId));
                }
            } catch (\Throwable $e) {
                return DocumentData::error($e);
            }

            $result = collect();
            $documents = $documents->sortable()->paginate(Document::getPaginateNumber());
            $documents->each(function($document) use(&$result){
                $result->add(DocumentData::fromApi($document));
            });

            return $documents;
        }

        try {
            $documents = Document::where('user_id', '=', $user->id)
                ->where('name', 'like', $search)
                ->orWhere('user_id', '=', $user->id)
                ->where('created_at', 'like', $search)
                ->orWhere('user_id', '=', $user->id)
                ->where('file_name', 'like', $search);

            // Чисто флекс методами строк ларавел, в курсе что мог сохранить строку до добавления %..%
            $searchWithoutPercents = Str::substr($search, 1, Str::of($search)->length()-2);
            $searchInAuthorName = Str::contains($user->name, $searchWithoutPercents, ignoreCase: true);
            if ($searchInAuthorName) {
                $documents->union(Document::orWhere('user_id', '=', $user->id));
            }
        } catch (\Throwable $e) {
            return DocumentData::error($e);
        }

        $result = collect();
        $documents = $documents->sortable()->paginate(Document::getPaginateNumber());
        $documents->each(function($document) use(&$result){
            $result->add(DocumentData::fromApi($document));
        });

        return $documents;
    }
}
