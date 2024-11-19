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
}
