<?php
declare(strict_types=1);

namespace App\Data;

use App\Contracts\FileRepositoryContract;
use App\Http\Requests\Document\StoreRequest;
use App\Http\Requests\Document\UpdateRequest;
use App\Models\Document;
use Illuminate\Support\Fluent;

class DocumentData extends Fluent
{
    //я может быть в типах обосралась хз
    /**
     * @property       integer   $user_id
     * @property       string    $name
     * @property       string    $file_name
     * @property       string    $file_path
     */
    public static function success(StoreRequest $request): DocumentData
    {
        //лучше вынести работу с файлом в отдельный репозиторий
        $fileRepository = app()->make(FileRepositoryContract::class);

        $userId = $request->getUserId();
        $file = $request->getFile();

        $data = new self();
        $data->user_id = $userId;
        $data->name = $request->getName();
        $data->file_name = $fileRepository->getFileName($file);
        $data->file_path = $fileRepository->getFilePath($file, $userId);

        $data->has_error = false;
        return $data;
    }

    public static function update(UpdateRequest $request): DocumentData
    {
        $document = Document::find($request->getDocumentId());
        $userId = $request->getUserId();
        $userAdmin = $request->isUserAdmin();

        $data = new self();

        if ($document->user_id == $userId || $userAdmin) {
            if ($request->getName() !== null)
            {
                $data->name = $request->getName();
            }

            $file = $request->getFile();
            if ($file !== null) {
                $fileRepository = app()->make(FileRepositoryContract::class);
                $data->file_name = $fileRepository->getFileName($file);
                $data->file_path = $fileRepository->getFilePath($file, $userId);
                $fileRepository->deleteOldFile($document->file_path);
            }

            $data->has_error = false;
            return $data;
        }

        $data->has_error = true;
        return $data;
    }

    public static function fromApi(Document $document)
    {
        //напиши тут что ты выводишь когда отдаешь в поиске, какие поля там нужны

    }

    //тут с $e могут быть проблемы с типами
    public static function error($e): DocumentData
    {
        $data = new self();
        $data->message = $e;

        $data->has_error = true;
        return $data;
    }
}
