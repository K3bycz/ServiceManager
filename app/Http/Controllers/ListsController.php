<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Devices;
use App\Models\Repairs;

class ListsController extends Controller
{
    public function showClients()
    {
        $clients = Clients::all();

        return view('list', [
            'title' => 'Lista klientów',
            'items' => $clients
        ]);
    }

    public function showDevices()
    {
        $devices = Devices::all();

        return view('list', [
            'title' => 'Lista sprzętów',
            'items' => $devices
        ]);
    }

    public function showRepairs()
    {
        $repairs = Repairs::all();

        return view('list', [
            'title' => 'Lista napraw',
            'items' => $repairs
        ]);
    }
}