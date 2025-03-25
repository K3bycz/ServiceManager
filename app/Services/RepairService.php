<?php

namespace App\Services;

use App\Models\Repair;
use App\Models\Client;
use Carbon\Carbon;

class RepairService{
    
    public function getMonthlyRepairs(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $monthlyRepairs = Repair::with(['device', 'device.client', 'status'])
        ->whereYear('date_received', $currentYear)
        ->whereMonth('date_received', $currentMonth)
        ->where('status_id', '!=', 4)
        ->get();

        return $monthlyRepairs;
    }

    public function getMonthlyEndedRepairs(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $endedRepairs = Repair::with(['device', 'device.client', 'status'])
        ->whereYear('date_received', $currentYear)
        ->whereMonth('date_received', $currentMonth)
        ->where('status', '=', 4)
        ->get();

        return $endedRepairs;
    }
}
