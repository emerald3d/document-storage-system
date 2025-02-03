<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Http\Services\DocumentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DocumentController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public DocumentService $service;

    public function __construct(DocumentService $service)
    {
        $this->service = $service;
    }
}
