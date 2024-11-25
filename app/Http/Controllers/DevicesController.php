<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Client;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function showList()
    {
        $data = Device::all();
        $title = "Urządzenia";
        $type = "device";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type]);
    }

    public function showCreateOrUpdateForm($id = null)
    {
        $device = null;
        $title = "Dane Klienta";

        if ($id) {
            $device = Device::findOrFail($id);
        }
        
        return view('devices.createOrUpdate', ['device' => $device, 'title' => $title]);
    }

    public function store(Request $request)
    {
        dd($request);
    }
}
