<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\RepairsController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\TripsController;
use App\Http\Controllers\EventsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DashboardsController::class, 'showDashboard'])->name('dashboard');
Route::get('/stats', [DashboardsController::class, 'showStatistics'])->name('stats');
Route::get('/bookkeeping', [DashboardsController::class, 'showBookkeeping'])->name('bookkeeping');

Route::get('/clients/search', [ClientsController::class, 'search'])->name('clients.search');

Route::get('/list/clients', [ClientsController::class, 'showList'])->name('clients.list');
Route::get('/list/devices', [DevicesController::class, 'showList'])->name('devices.list');
Route::get('/list/repairs', [RepairsController::class, 'showList'])->name('repairs.list');
Route::get('/list/orders', [OrdersController::class, 'showList'])->name('orders.list');
Route::get('/list/trips', [TripsController::class, 'showList'])->name('trips.list');
Route::get('/list/events', [EventsController::class, 'showList'])->name('events.list');

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

Route::get('order/create', [OrdersController::class, 'showCreateOrUpdateForm'])->name('orders.create');
Route::get('order/{id}/edit', [OrdersController::class, 'showCreateOrUpdateForm'])->name('orders.edit');
Route::post('/order/store', [OrdersController::class, 'store'])->name('orders.store');

Route::get('trip/create', [TripsController::class, 'showCreateOrUpdateForm'])->name('trips.create');
Route::get('trip/{id}/edit', [TripsController::class, 'showCreateOrUpdateForm'])->name('trips.edit');
Route::post('/trip/store', [TripsController::class, 'store'])->name('trips.store');

Route::get('event/create', [EventsController::class, 'showCreateOrUpdateForm'])->name('events.create');
Route::get('event/{id}/edit', [EventsController::class, 'showCreateOrUpdateForm'])->name('events.edit');
Route::post('/event/store', [EventsController::class, 'store'])->name('events.store');

Route::fallback(function () {
    return redirect('/');
});