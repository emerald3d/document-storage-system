<?php

namespace App\Http\Controllers\Document;

use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class CreateController extends DocumentController
{
    public function __invoke(): View
    {
        return view('document.create');
    }
}
