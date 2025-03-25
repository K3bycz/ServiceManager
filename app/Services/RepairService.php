<?php

namespace App\Services;

use App\Models\Repair;
use App\Models\Client;
use Carbon\Carbon;

class RepairService{
    
    public function getMonthlyRepairs(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $monthlyRepairs = Repair::with(['device', 'device.client'])
        ->whereYear('date_received', $currentYear)
        ->whereMonth('date_received', $currentMonth)
        ->get();

        return $monthlyRepairs;
    }
}