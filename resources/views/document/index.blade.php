@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('document.index')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($documents->isNotEmpty())
                    <div class="row row-cols-4">
                        <h5>@sortablelink('name', 'Название')</h5>
                        <h5>@sortablelink('created_at', 'Дата')</h5>
                        <h5>@sortablelink('user.name', 'Автор')</h5>
                        <h5>Файл</h5>
                    </div>
                    @foreach($documents as $document)
                        <div class="card text-dark bg-light mb-3">
                            <div class="card-body">
                                <div class="row row-cols-4">
                                    <div class="col">{{ $document->name  }}</div>
                                    <div class="col">{{ $document->created_at  }}</div>
                                    <div class="col">{{ $document->user->name  }}</div>
                                    <a class="icon-link" href="{{ Storage::url($document['file_path']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                             class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0"/>
                                        </svg>
                                        {{ $document->file_name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {!! $documents->appends(\Request::except('page'))->render() !!}
                @else
                    <h5>Ничего не найдено.</h5>
                @endif
            </div>
        </div>
    </div>
@endsection
