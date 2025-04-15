<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function showList(){
        $data = Order::orderBy('id', 'desc')->paginate(15);

        $title = "Zamówienia";
        $type = "order";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type,]);
    }

    public function showCreateOrUpdateForm($id = null)
    {
        $order  = null;
        $title = "Dane Zamówienia";

        if ($id) {
            $order = Order::findOrFail($id);   
        }
        
        return view('orders.createOrUpdate', ['order' => $order,'title' => $title,]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:50',
            'link' => 'required|string|max:150',
            'status' => 'required|string',
            'warehouse' => 'required|string|max:30',
            'repair_id' => 'nullable|integer'
        ]);

        if ($request->id) {
            $order = Order::findOrFail($request->id);
            $order->update($validatedData);
        } else {
            $order = Order::create($validatedData);
        }

        if ($request->action === 'save_and_close') {
            return redirect()->route('orders.list')->with('success', 'Dane zamówienia zostały zapisane.');
        }

        return redirect()->route('orders.edit', [ 'id' => $order->id])
            ->with('success', 'Dane zamówienia zostały zapisane.');
    }
}