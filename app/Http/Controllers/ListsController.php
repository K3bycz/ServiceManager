<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Device;
use App\Models\Repair;

class ListsController extends Controller
{
    public function showList(string $type)
    {
        $data = match ($type) {
            'clients' => ['title' => 'Lista klientów', 'items' => Client::all()],
            'devices' => ['title' => 'Lista sprzętów', 'items' => Device::all()],
            'repairs' => ['title' => 'Lista napraw', 'items' => Repair::all()],
            default => abort(404, 'Nieznany typ listy'),
        };

        return view('list', $data);
    }
}
