<?php

namespace App\Services;

use App\Models\Repair;
use App\Models\Order;
use Carbon\Carbon;

class OrderService{

    public function getOrderForRepair($repair_id){

        $orders = Order::where('repair_id', $repair_id )->get();

        return $orders->isEmpty() ? null : $orders;
    }

    public function getUnlcaimedOrders(){

        $orders = Order::where('status', '!=', 'Odebrane')->get();

        return $orders->isEmpty() ? null : $orders;
    }
}