<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Client;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function showList()
    {
        $data = Device::with('client')->paginate(15);
        $title = "Urządzenia";
        $type = "device";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type]);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'owner', 'id');
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
        $request->merge(['owner' => $request->input('owner_id')]);

        $validatedData = $request->validate([
            'owner_id' => 'required|integer',
            'owner' => 'required|integer',
            'category' => 'required|string|max:30',
            'manufacturer' => 'required|string|max:30',
            'serialNumber' => 'nullable|string|max:30',
            'model' => 'nullable|string|max:30',
        ]);

        if ($request->id) {
            $client = Device::findOrFail($request->id);
            $client->update($validatedData);
        } else {
            Device::create($validatedData);
        }

        return redirect()->route('devices.list')->with('success', 'Urządzenie zostało zapisane.');
    }
}
