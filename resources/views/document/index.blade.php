@extends('layouts.app')

@section('document.index')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <div class="row row-cols-4">
                    <div class="col">Название</div>
                    <div class="col">Дата</div>
                    <div class="col">Автор</div>
                    <div class="col">Файл</div>
                </div>
            </div>
            @foreach($documents as $document)
                <div class="card">
                    <div class="row row-cols-4">
                        <div class="col">{{ $document->name  }}</div>
                        <div class="col">{{ $document->created_at  }}</div>
                        <div class="col">{{ $document->user->name  }}</div>
                        <a class="icon-link" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0"/>
                            </svg>
                            {{ $document->file_name }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
