<?php

namespace App\Http\Controllers;

use App\Models\Repair;

class RepairsController extends Controller
{
    public function showList()
    {
        $data = Repair::all();
        $title = "Naprawy";

        return view('list', ['data' => $data, 'title' => $title]);
    }
}
