<?php

namespace App\Http\Controllers\Document;

use App\Models\Document;
use Illuminate\View\View;

class IndexController extends DocumentController
{
    public function __invoke(): View
    {
        $documents = Document::sortable()->paginate(8);

        return view('document.index', compact('documents'));
    }
}
