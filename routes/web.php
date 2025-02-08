<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::redirect('/', '/documents');

Route::group(['middleware' => 'auth'], function () {
    //тут возможно наебнулось, надо проверить
    Route::controller(DocumentController::class)->prefix('documents')->group( function () {
        Route::get('', 'index')->name('document.index');
        Route::get('/create', 'create')->name('document.create');
        Route::post('/create', 'store')->name('document.store');
        Route::get('/search', 'search')->name('document.search');
    });
});
