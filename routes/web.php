<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list/{type}', [ListsController::class, 'showList'])->name('list');