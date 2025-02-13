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
        Route::get('/edit/{document}', 'edit')->name('document.edit');
        Route::patch('/edit/{document}', 'update')->name('document.update');
        Route::delete('/delete/{document}', 'delete')->name('document.delete');
        Route::get('/search', 'search')->name('document.search');
    });
    Route::group(['prefix' => 'admin'], function () {
        Voyager::routes();
    });
});

