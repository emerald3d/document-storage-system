<?php

namespace App\Http\Controllers\Document;

use App\Http\Requests\Document\StoreRequest;
use Illuminate\Http\RedirectResponse;

class StoreController extends DocumentController
{
    public function __invoke(StoreRequest $request): RedirectResponse
    {
        $this->service->store($request);

        return redirect()->route('document.index');
    }
}
