<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Support\Fluent;

class DocumentListData extends Fluent
{
    public static function success(Colection $documents): self
    {
        $data = new self();
        $data->documents = DocumentListData::success($documents);

        $data->has_error = false;
        return $data;
    }

    //тут с $e могут быть проблемы с типами
    public static function error($e): self
    {
        $data = new self();
        $data->message = $e;

        $data->has_error = true;
        return $data;
    }
}
