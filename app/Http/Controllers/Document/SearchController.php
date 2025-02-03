<?php

namespace App\Http\Controllers\Document;

use App\Http\Requests\Document\SearchRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\View\View;

class SearchController extends DocumentController
{
    public function __invoke(SearchRequest $request): View
    {
        $documents = $this->service->search($request);

        return view('document.index', compact('documents'));
    }
}
