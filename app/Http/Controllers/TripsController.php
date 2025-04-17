<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    public function showList()
    {
        $data = Trip::paginate(15);
        $title = "Wyjazdy";
        $type = "trip";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type]);
    }

    public function showCreateOrUpdateForm($id = null)
    {
        $trip = null;
        $mapUrl = null;
        $title = "Dane Wyjazdu";

        if ($id) {
            $trip = Trip::findOrFail($id);   
            $address = urlencode($trip->address);
            $mapUrl = "https://maps.google.com/maps?q={$address}&t=&z=13&ie=UTF8&iwloc=&output=embed";
        }
        
        return view('trips.createOrUpdate', ['trip' => $trip, 'title' => $title, 'mapUrl' => $mapUrl]);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:100',
            'address' => 'required|string|max:70',
            'date' => 'required|date',
        ]);

        if ($request->id) {
            $trip = Trip::findOrFail($request->id);
            $trip->update($validatedData);
        } else {
            $trip = Trip::create($validatedData);
        }

        if ($request->action === 'save_and_close') {
            return redirect()->route('trips.list')->with('success', 'Wyjazd został zapisany.');
        }

        return redirect()->route('trips.edit', [ 'id' => $trip->id])
            ->with('success', 'Wyjazd został zapisany.');
        
    }
}