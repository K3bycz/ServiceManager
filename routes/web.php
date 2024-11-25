<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\RepairsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list/clients', [ClientsController::class, 'showList'])->name('clients.list');
Route::get('/list/devices', [DevicesController::class, 'showList'])->name('devices.list');
Route::get('/list/repairs', [RepairsController::class, 'showList'])->name('repairs.list');

Route::get('client/create', [ClientsController::class, 'showCreateOrUpdateForm'])->name('clients.create');
Route::get('client/{id}/edit', [ClientsController::class, 'showCreateOrUpdateForm'])->name('clients.edit');
Route::post('/clients/store', [ClientsController::class, 'store'])->name('clients.store');

Route::get('device/create', [DevicesController::class, 'showCreateOrUpdateForm'])->name('devices.create');
Route::get('device/{id}/edit', [DevicesController::class, 'showCreateOrUpdateForm'])->name('devices.edit');
