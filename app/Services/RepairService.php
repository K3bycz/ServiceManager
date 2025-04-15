<?php

namespace App\Services;

use App\Models\Repair;
use App\Models\Client;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        ->where('status_id', '=', 4)
        ->get();

        return $endedRepairs;
    }

    public function getYearlyRepairStats()
    {
        $repairs = Repair::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('EXTRACT(MONTH FROM date_received) as month')
        )
        ->whereRaw('EXTRACT(YEAR FROM date_received) = ?', [date('Y')])
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $endedRepairs = Repair::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('EXTRACT(MONTH FROM date_released) as month')
        )
        ->whereRaw('EXTRACT(YEAR FROM date_released) = ?', [date('Y')])
        ->where('status_id', 4)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $months = range(1, 12);
        $repairsData = array_fill(0, 12, 0);
        $endedRepairsData = array_fill(0, 12, 0);

        foreach ($repairs as $repair) {
            $repairsData[$repair->month - 1] = $repair->count;
        }

        foreach ($endedRepairs as $repair) {
            $endedRepairsData[$repair->month - 1] = $repair->count;
        }

        return [
            'yearlyRepairs' => $repairsData,
            'yearlyEndedRepairs' => $endedRepairsData,
        ];
    }

    public function getMonthlyRepairStats()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        $repairs = Repair::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('EXTRACT(DAY FROM date_received) as day')
        )
        ->whereRaw('EXTRACT(YEAR FROM date_received) = ?', [$currentYear])
        ->whereRaw('EXTRACT(MONTH FROM date_received) = ?', [$currentMonth])
        ->groupBy('day')
        ->orderBy('day')
        ->get();

        $endedRepairs = Repair::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('EXTRACT(DAY FROM date_released) as day')
        )
        ->whereRaw('EXTRACT(YEAR FROM date_released) = ?', [$currentYear])
        ->whereRaw('EXTRACT(MONTH FROM date_released) = ?', [$currentMonth])
        ->where('status_id', 4)
        ->groupBy('day')
        ->orderBy('day')
        ->get();

        $daysInMonth = Carbon::create($currentYear, $currentMonth)->daysInMonth;
        $repairsData = array_fill(0, $daysInMonth, 0);
        $endedRepairsData = array_fill(0, $daysInMonth, 0);

        foreach ($repairs as $repair) {
            $repairsData[$repair->day - 1] = $repair->count;
        }

        foreach ($endedRepairs as $repair) {
            $endedRepairsData[$repair->day - 1] = $repair->count;
        }

        $dailyLabels = range(1, $daysInMonth);

        return [
            'monthlyRepairs' => $repairsData,
            'monthlyEndedRepairs' => $endedRepairsData,
            'dailyLabels' => $dailyLabels
        ];
    }

    public function getNewDevices()
    {
        $currentYear = date('Y');
    
        $deviceCategories = Device::select(
            'category',
            DB::raw('COUNT(*) as count')
        )
        ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [$currentYear])
        ->groupBy('category')
        ->orderBy('count', 'desc')
        ->get();

        $categories = [];
        $categoryData = [];
    
        foreach ($deviceCategories as $device) {
            $categories[] = $device->category;
            $categoryData[] = $device->count;
        }
    
        return [
            'deviceCategories' => $categories,
            'deviceCounts' => $categoryData,
        ];
    }

    public function getNewCustomers()
    {
        $currentYear = date('Y');
        
        $customers = Client::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('EXTRACT(MONTH FROM created_at) as month')
        )
        ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [$currentYear])
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        $months = range(1, 12);
        $customersData = array_fill(0, 12, 0);
        
        foreach ($customers as $customer) {
            $customersData[$customer->month - 1] = $customer->count;
        }
        
        return [
            'newCustomers' => $customersData
        ];
    }

    public function getMonthlyEarningsData()
    {
        $currentYear = now()->year;
        $currentMonthNumber = now()->month;
        $currentMonth = now()->format('Y-m');
        
        $daysInMonth = Carbon::createFromDate($currentYear, $currentMonthNumber)->daysInMonth;
        
        $dailyData = Repair::where('status_id', 4)
            ->whereYear('date_released', $currentYear)
            ->whereMonth('date_released', $currentMonthNumber)
            ->select(
                DB::raw('DATE(date_released) as day'),
                DB::raw('SUM(profit) as total_profit')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get();
        
        $dailyDataByDay = [];
        foreach ($dailyData as $data) {
            $day = (int)date('d', strtotime($data->day));
            $dailyDataByDay[$day] = $data;
        }
        
        $dailyLabels = [];
        $dailyProfits = [];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dailyLabels[] = $day;
           
            if (isset($dailyDataByDay[$day])) {
                $dailyProfits[] = (float)$dailyDataByDay[$day]->total_profit;
            } else {
                $dailyProfits[] = null;
            }
        }
        
        $summaryStats = Repair::where('status_id', 4)
            ->whereYear('date_released', $currentYear)
            ->whereMonth('date_released', $currentMonthNumber)
            ->select(
                DB::raw('SUM(costs) as total_costs'),
                DB::raw('SUM(revenue) as total_revenue'),
                DB::raw('SUM(profit) as total_profit')
            )
            ->first();
        $currentMonth = ucfirst(now()->locale('pl')->translatedFormat('F Y'));
        return [
            'dailyProfits' => $dailyProfits,
            'summaryStats' => $summaryStats,
            'currentMonth' => $currentMonth,
            'dailyLabels' => $dailyLabels,
        ];
    }

    public function getYearlyEarningsData(){
        $currentYear = now()->year;
        $monthlyRevenues = [];
        $monthlyCosts = [];
        
        $monthNames = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::create($currentYear , $i, 1);
            $monthName = ucfirst($date->locale('pl')->translatedFormat('F'));
            $monthNames[] = $monthName;
        }
        
        $monthlyData = Repair::where('status_id', 4)
            ->whereYear('date_released', $currentYear)
            ->select(
                DB::raw('EXTRACT(MONTH FROM date_released) as month'),
                DB::raw('SUM(revenue) as total_revenue'),
                DB::raw('SUM(costs) as total_costs'),
                DB::raw('SUM(profit) as total_profit')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $monthlyDataByMonth = [];
        foreach ($monthlyData as $data) {
            $monthlyDataByMonth[(int)$data->month] = $data;
        }
        
        for ($month = 1; $month <= 12; $month++) {
            if (isset($monthlyDataByMonth[$month])) {
                $monthlyCosts[] = (float)$monthlyDataByMonth[$month]->total_costs;
                $monthlyRevenues[] = (float)$monthlyDataByMonth[$month]->total_revenue;
            } else {
                $monthlyCosts[] = 0;
                $monthlyRevenues[] = 0;
            }
        }
        
        return [
            'monthNames' => $monthNames,
            'monthlyCosts' => $monthlyCosts,
            'monthlyRevenues' => $monthlyRevenues,
        ];
    }
}
