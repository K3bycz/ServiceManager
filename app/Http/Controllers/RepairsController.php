<?php

namespace App\Http\Controllers;

use App\Models\Repair;

class RepairsController extends Controller
{
    public function showList()
    {
        $data = Repair::all();
        $title = "Naprawy";
        $type = "repair";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type]);
    }

    public function showCreateOrUpdateForm($id = null)
    {
        $repair = null;
        $title = "Dane Naprawy";

        if ($id) {
            $repair = Repair::with('device')->findOrFail($id);        
        }
        
        return view('repairs.createOrUpdate', ['repair' => $repair, 'title' => $title]);
    }

}
