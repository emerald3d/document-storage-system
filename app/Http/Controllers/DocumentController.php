<?php

namespace App\Http\Controllers;

use App\Contracts\DocumentRepositoryContract;
use App\Data\DocumentData;
use App\Http\Requests\Document\SearchRequest;
use App\Http\Requests\Document\StoreRequest;
use App\Http\Requests\Document\UpdateRequest;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin())
        {
            $documents = Document::sortable()->paginate(Document::getPaginateNumber());

            return view('document.index', compact('documents'));
        }

        $documents = $user->documents;

        if ($documents->isNotEmpty())
        {
            $documents = $user->documents->toQuery()->sortable()->paginate(Document::getPaginateNumber());
        } else
        {
            $documents = collect();
        }

        return view('document.index', compact('documents'));
    }

    public function create(): View
    {
        return view('document.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        // Чет не понял прикол выносить это в репозиторий) так нелья?:
        // Document::create(DocumentData::success($request)->toArray());
        $documentRepository = app()->make(DocumentRepositoryContract::class);
        $documentRepository->store($request);

        return redirect()->route('document.index');
    }

    public function edit(int $documentId): View|RedirectResponse
    {
        $document = Document::find($documentId);

        if ($document && $document->user_id === auth()->id() || auth()->user()->isAdmin())
        {
            return view('document.edit', compact('document'));
        }

        return redirect()->route('document.index');
    }

    public function update(UpdateRequest $request): RedirectResponse
    {
        $documentRepository = app()->make(DocumentRepositoryContract::class);
        $documentRepository->update($request);

        return redirect()->route('document.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        $document = Document::find($request->input('document'));
        if ($document && $document->user_id === auth()->id() || auth()->user()->isAdmin())
        {
            $document->delete();
        }

        return redirect()->route('document.index');
    }

    public function search(SearchRequest $request): View
    {
        $search = $request->input('search');
        $user = $request->user();

        $documentRepository = app()->make(DocumentRepositoryContract::class);

        $documents = $documentRepository->search($search, $user);

        //это случай ошибки бд
        if ($documents instanceof DocumentData) {
            //возможно отдавать другой view с ошибкой
        }

        return view('document.index', compact('documents'));
    }
}
