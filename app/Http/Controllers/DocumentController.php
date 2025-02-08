<?php

namespace App\Http\Controllers;

use App\Data\DocumentData;
use App\Http\Requests\Document\SearchRequest;
use App\Http\Requests\Document\StoreRequest;
use App\Http\Services\DocumentService;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public DocumentService $service;

    public function __construct(DocumentService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        $documents = Document::sortable()->paginate(8);

        return view('document.index', compact('documents'));
    }

    public function create(): View
    {
        return view('document.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->service->store($request);

        return redirect()->route('document.index');
    }

    public function search(SearchRequest $request): View
    {
        $documents = $this->service->search($request->input('search'));
        //это случай ошибки бд
        if ($documents instanceof DocumentData) {
            //возможно отдавать другой view с ошибкой
        }

        return view('document.index', compact('documents'));
    }
}
