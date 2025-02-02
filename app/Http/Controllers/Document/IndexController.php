<?php

namespace App\Http\Controllers\Document;

use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class IndexController extends DocumentController
{
    public function __invoke()
    {
        $documents = Document::all();
        return view('document.index', compact('documents'));
    }
}
