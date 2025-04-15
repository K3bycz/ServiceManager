<?php

namespace App\Http\Controllers;

use App\Services\RepairService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardsController extends Controller
{
    protected $repairService;

    public function __construct(RepairService $repairService)
    {
        $this->repairService = $repairService;
    }

    public function showDashboard(){
        $title ='Pulpit';

        Carbon::setLocale('pl');
        $currentMonth = Carbon::now()->translatedFormat('F');
        $currentMonth = mb_convert_case(Carbon::now()->translatedFormat('F'), MB_CASE_TITLE, 'UTF-8');
        
        $currentRepairs = $this->repairService->getMonthlyRepairs();
        $endedRepairs = $this->repairService->getMonthlyEndedRepairs();

        return view('dashboards.dashboard', ['title' => $title, 'currentRepairs' => $currentRepairs, 'endedRepairs' => $endedRepairs, 'currentMonth' => $currentMonth]);
    }

    public function showStatistics(){
        $title ='Statystyki';
        
        $yearlyStats = $this->repairService->getYearlyRepairStats();
        $monthlyStats = $this->repairService->getMonthlyRepairStats();
        $deviceStats = $this->repairService->getNewDevices();
        $customerStats = $this->repairService->getNewCustomers();

        return view('dashboards.stats', [
            'title' => $title,
            'yearlyRepairs' => $yearlyStats['yearlyRepairs'],
            'yearlyEndedRepairs' => $yearlyStats['yearlyEndedRepairs'],
            'monthlyRepairs' => $monthlyStats['monthlyRepairs'],
            'monthlyEndedRepairs' => $monthlyStats['monthlyEndedRepairs'],
            'dailyLabels' => $monthlyStats['dailyLabels'],
            'deviceCategories' => $deviceStats['deviceCategories'],
            'deviceCounts' => $deviceStats['deviceCounts'],
            'newCustomers' => $customerStats['newCustomers'],
        ]);    
    }

    public function showBookkeeping(){
        $title ='Ksiegowość';
        $monthlyEarningsData = $this->repairService->getMonthlyEarningsData();
        $yearlyEarningsData  = $this->repairService->getYearlyEarningsData();

        return view('dashboards.bookkeeping', [
            'title' => $title,
            'summaryStats' => $monthlyEarningsData['summaryStats'],
            'dailyProfits' => $monthlyEarningsData['dailyProfits'],
            'currentMonth' => $monthlyEarningsData['currentMonth'],
            'dailyLabels' => $monthlyEarningsData['dailyLabels'],
            'monthNames' => $yearlyEarningsData['monthNames'],
            'monthlyCosts' => $yearlyEarningsData['monthlyCosts'],
            'monthlyRevenues' => $yearlyEarningsData['monthlyRevenues'],
        ]);    
    }
}