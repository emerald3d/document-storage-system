<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::redirect('/', '/documents');

Route::group(['middleware' => 'auth'], function () {
    Route::controller(DocumentController::class)->group( function () {
        Route::get('/documents', 'index')
            ->name('document.index');
        Route::get('/documents/create', 'create')
            ->name('document.create');
        Route::post('/documents/create', 'store')
            ->name('document.store');
        Route::get('/documents/search', 'search')
            ->name('document.search');
    });
});
