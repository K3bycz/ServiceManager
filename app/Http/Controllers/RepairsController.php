<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Device;
use App\Models\Client;
use Illuminate\Http\Request;

class RepairsController extends Controller
{
    public function showList()
    {
        $data = Repair::paginate(15);
        $title = "Naprawy";
        $type = "repair";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type]);
    }

    public function showCreateOrUpdateForm($deviceId, $id = null)
    {
        $repair = null;
        $device = Device::findOrFail($deviceId);
        $client = Client::where('id', $device->owner)->first();
        $title = "Dane Naprawy";

        if ($id) {
            $repair = Repair::findOrFail($id);   
        }
        
        return view('repairs.createOrUpdate', ['repair' => $repair, 'device' => $device, 'client' => $client, 'title' => $title]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'device' => 'required|exists:devices,id',
            'status' => 'required|string',
            'date_received' => 'nullable|date',
            'date_released' => 'nullable|date',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'costs' => 'nullable|numeric',
            'revenue' => 'nullable|numeric',
        ]);

        if ($request->id) {
            $repair = Repair::findOrFail($request->id);
            $repair->update($validatedData);
        } else {
            Repair::create($validatedData);
        }

        return redirect()->route('repairs.list')->with('success', 'Naprawa została zapisana.');

    }
}
