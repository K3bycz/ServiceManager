<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function showList()
    {
        $data = Client::all();
        $title = "Klienci";
        
        return view('list', ['data' => $data, 'title' => $title]);
    }

    public function showCreateOrUpdateForm($id = null)
    {
        $client = null;
        $title = "Dane Klienta";

        if ($id) {
            $client = Client::findOrFail($id);
        }
        
        return view('clients.createOrUpdate', ['client' => $client, 'title' => $title]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'phoneNumber' => 'required|string|max:10',
        ]);

        if ($request->id) {
            $client = Client::findOrFail($request->id);
            $client->update($validatedData);
        } else {
            Client::create($validatedData);
        }

        return redirect()->route('clients.list')->with('success', 'Dane klienta zostały zapisane.');
    }
}
