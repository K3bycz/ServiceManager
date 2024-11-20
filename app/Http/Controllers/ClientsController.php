<?php

namespace App\Http\Controllers;

use App\Models\Client;

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

        if ($id) {
            $client = Client::findOrFail($id);
        }
        
        return view('clients.createOrUpdate', compact('client'));
    }
}
