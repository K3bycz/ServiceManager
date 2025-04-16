<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Client;
use App\Models\Repair;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function showList(Request $request)
    {
        $query = Device::query()->with('client');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('manufacturer', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('model', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('category', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('serialNumber', 'ILIKE', "%{$searchTerm}%")
                  ->orWhereHas('client', function($subQuery) use ($searchTerm) {
                      $subQuery->where('name', 'ILIKE', "%{$searchTerm}%")
                               ->orWhere('surname', 'ILIKE', "%{$searchTerm}%")
                               ->orWhere('phoneNumber', 'ILIKE', "%{$searchTerm}%");
                  });
            });
        }
        
        $query->orderBy('id', 'desc');
        $data = $query->paginate(15);

        $title = "Urządzenia";
        $type = "device";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type]);
    }
    

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
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
        $request->merge(['client_id' => $request->input('owner_id')]);

        $validatedData = $request->validate([
            'owner_id' => 'required|integer',
            'client_id' => 'required|integer',
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
            $repairs = Repair::where('device_id', $id)->paginate(10);
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
