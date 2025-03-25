<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\RepairsController;
use App\Http\Controllers\DashboardsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DashboardsController::class, 'showDashboard'])->name('dashboard');
Route::get('/stats', [DashboardsController::class, 'showStatistics'])->name('stats');

Route::get('/clients/search', [ClientsController::class, 'search'])->name('clients.search');

Route::get('/list/clients', [ClientsController::class, 'showList'])->name('clients.list');
Route::get('/list/devices', [DevicesController::class, 'showList'])->name('devices.list');
Route::get('/list/repairs', [RepairsController::class, 'showList'])->name('repairs.list');

Route::get('client/create', [ClientsController::class, 'showCreateOrUpdateForm'])->name('clients.create');
Route::get('client/{id}/edit', [ClientsController::class, 'showCreateOrUpdateForm'])->name('clients.edit');
Route::post('/clients/store', [ClientsController::class, 'store'])->name('clients.store');

Route::get('device/create', [DevicesController::class, 'showCreateOrUpdateForm'])->name('devices.create');
Route::get('device/{id}/edit', [DevicesController::class, 'showCreateOrUpdateForm'])->name('devices.edit');
Route::post('/devices/store', [DevicesController::class, 'store'])->name('devices.store');
Route::get('device/{id}/repairs', [DevicesController::class, 'showRepairs'])->name('device.repairs');

Route::get('repairs/{deviceId}/create', [RepairsController::class, 'showCreateOrUpdateForm'])->name('repairs.create');
Route::get('repairs/{deviceId}/{id}/edit', [RepairsController::class, 'showCreateOrUpdateForm'])->name('repairs.edit');
Route::post('/repairs/store', [RepairsController::class, 'store'])->name('repairs.store');
