<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Client;
use App\Models\Repair;
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
        $title = "Dane Sprzętu";

        if ($id) {
            $device = Device::with('client')->findOrFail($id);        
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
            $device = Device::findOrFail($request->id);
            $device->update($validatedData);
        } else {
            $device = Device::create($validatedData);
        }

        if ($request->action === 'save_and_close') {
            return redirect()->route('devices.list')->with('success', 'Urządzenie zostało zapisane.');
        }

        return redirect()->route('devices.edit', [ 'id' => $device->id])
            ->with('success', 'Urządzenie zostało zapisane.');
        
    }

    public function showRepairs($id)
    {   

        if ($id) {
            $repairs = Repair::where('device', $id)->paginate(10);
            $device = Device::with('client')->findOrFail($id); 
        }

        if ($device) {
            $title = "Naprawy: " . $device->manufacturer . " " . $device->model;
        } else {
            $title = "Naprawy: Nieznane urządzenie";
        }
        return view('devices.repairList', ['repairs' => $repairs, 'device' => $device, 'title' => $title]);
    }
}
