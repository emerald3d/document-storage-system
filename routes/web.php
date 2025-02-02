<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Document\IndexController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/docs', IndexController::class)->name('document.index');
