<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clients', [ListsController::class, 'showClients']);
Route::get('/devices', [ListsController::class, 'showDevices']);
Route::get('/repairs', [ListsController::class, 'showRepairs']);

