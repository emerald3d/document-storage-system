<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Collection;//todo не та коллекция подключена
use App\Contracts\DocumentRepositoryContract;
use App\Data\DocumentItemData;
use App\Http\Requests\Document\StoreRequest;
use App\Http\Requests\Document\UpdateRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class DocumentRepository implements DocumentRepositoryContract
{
    //todo убирай из параметров request  вводи либо DTO либо нужные тебе параметры,
    // сейчас вообще не понятно какие данные в методах создания/удаления засовываешь
    // мне в целом не нравится этот репозиторий т.к он отдает уже данные для вывода,
    // его смысл только в модельню работать. Параметры DTO а вот ответ как коллекция или элемент
    public function store(StoreRequest $request): void
    {
        Document::create(DocumentItemData::success($request)->toArray());
    }

    public function update(UpdateRequest $request): void
    {
        // А тут и в create не надо try-catch, с бд же работа? Или оно автоматом проверяет
        //да, вынеси в action try catch
        $document = Document::find($request->getDocumentId());
        $data = DocumentItemData::update($request)->toArray();
        $document->update($data);
    }

    public function searchForAdmin(string $search, User $user): Collection
    {
        $authors = User::where('name', 'like', $search)->get()->modelKeys();

        $documents = Document::where('name', 'like', $search) // Чисто визуальнее красивее
        ->orWhere('created_at', 'like', $search)
            ->orWhere('file_name', 'like', $search); // Пусть будет тоже, хоть и необязательно)

        foreach ($authors as $authorUserId) {
            $documents->union(Document::where('user_id', 'like', $authorUserId));
        }
        return $documents;
    }

    public function searchForUser(string $search, User $user): Collection
    {
        $documents = Document::where('user_id', '=', $user->id)
            ->where('name', 'like', $search)
            ->orWhere('user_id', '=', $user->id)
            ->where('created_at', 'like', $search)
            ->orWhere('user_id', '=', $user->id)
            ->where('file_name', 'like', $search);

        //не обязательно Str лупить, там базовые методы самой пыхи есть такие
        // Чисто флекс методами строк ларавел, в курсе что мог сохранить строку до добавления %..%
        $searchWithoutPercents = Str::substr($search, 1, Str::of($search)->length()-2);
        $searchInAuthorName = Str::contains($user->name, $searchWithoutPercents, ignoreCase: true);
        if ($searchInAuthorName) {
            $documents->union(Document::orWhere('user_id', '=', $user->id));
        }

        return $documents;
    }
}
