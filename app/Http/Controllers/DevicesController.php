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
}
