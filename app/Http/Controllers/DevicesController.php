<?php

namespace App\Http\Controllers;

use App\Models\Device;

class DevicesController extends Controller
{
    public function showList()
    {
        $data = Device::all();
        $title = "Urządzenia";

        return view('list', ['data' => $data, 'title' => $title]);
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
}
