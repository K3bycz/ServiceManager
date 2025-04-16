<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Device;
use App\Models\Client;
use App\Models\RepairStatus;
use App\Services\OrderService;
use Illuminate\Http\Request;

class RepairsController extends Controller
{
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function showList(Request $request)
    {
        $query = Repair::query()->with(['device.client', 'status']);
    
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'ILIKE', "%{$searchTerm}%")
                ->orWhere('id', 'ILIKE', "%{$searchTerm}%")
                ->orWhere('date_received', 'ILIKE', "%{$searchTerm}%")
                ->orWhere('date_released', 'ILIKE', "%{$searchTerm}%")
                ->orWhere('revenue', 'ILIKE', "%{$searchTerm}%")
                ->orWhereHas('status', function($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'ILIKE', "%{$searchTerm}%");
                })
                ->orWhereHas('device', function($deviceQuery) use ($searchTerm) {
                    $deviceQuery->where('manufacturer', 'ILIKE', "%{$searchTerm}%")
                                ->orWhere('model', 'ILIKE', "%{$searchTerm}%")
                                ->orWhereHas('client', function($clientQuery) use ($searchTerm) {
                                    $clientQuery->where('name', 'ILIKE', "%{$searchTerm}%")
                                                ->orWhere('surname', 'ILIKE', "%{$searchTerm}%")
                                                ->orWhere('phoneNumber', 'ILIKE', "%{$searchTerm}%");
                                });
                });
            });
        }
    
        $query->orderBy('id', 'desc');
        $data= $query->paginate(15);

        $title = "Naprawy";
        $type = "repair";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type]);
    }

    public function showCreateOrUpdateForm($deviceId, $id = null)
    {
        $repair = null;
        $orders = null;
        $device = Device::findOrFail($deviceId);
        $client = Client::where('id', $device->client_id)->first();
        $statuses = RepairStatus::all();
        $title = "Dane Naprawy";

        if ($id) {
            $repair = Repair::findOrFail($id);
            $orders = $this->orderService->getOrderForRepair($id);
        }
        
        return view('repairs.createOrUpdate', ['repair' => $repair, 'device' => $device, 'client' => $client, 'title' => $title, 'statuses' => $statuses, 'orders' => $orders]);
    }

    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'status_id' => 'required|string',
            'date_received' => 'nullable|date',
            'date_released' => 'nullable|date',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'costs' => 'nullable|numeric',
            'revenue' => 'nullable|numeric',
        ]);

        $costs = $validatedData['costs'] ?? 0;
        $revenue = $validatedData['revenue'] ?? 0;
        $validatedData['profit'] = $revenue - $costs;

        if ($request->id) {
            $repair = Repair::findOrFail($request->id);
            $repair->update($validatedData);
        } else {
            $repair = Repair::create($validatedData);
        }

        if ($request->action === 'save_and_close') {
            return redirect()->route('repairs.list')->with('success', 'Naprawa została zapisana.');
        }

        return redirect()->route('repairs.edit', ['deviceId' => $request->device_id, 'id' => $repair->id])
            ->with('success', 'Naprawa została zapisana.');
    }
}
