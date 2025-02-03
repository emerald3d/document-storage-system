<?php

use App\Http\Controllers\Document\CreateController;
use App\Http\Controllers\Document\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Document\IndexController;
use App\Http\Controllers\Document\StoreController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', IndexController::class)->name('document.index');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/documents/create', CreateController::class)->name('document.create');
    Route::post('/documents/create', StoreController::class)->name('document.store');
    Route::get('/documents/search', SearchController::class)->name('document.search');
});
