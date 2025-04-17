<?php

namespace App\Http\Controllers;

use App\Services\RepairService;
use App\Services\OrderService;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardsController extends Controller
{
    protected $repairService, $orderService, $calendarService;

    public function __construct(RepairService $repairService, OrderService $orderService, CalendarService $calendarService)
    {
        $this->repairService = $repairService;
        $this->orderService = $orderService;
        $this->calendarService = $calendarService;
    }

    public function showDashboard(){
        $title ='Pulpit';

        Carbon::setLocale('pl');
        $currentMonth = Carbon::now()->translatedFormat('F');
        $currentMonth = mb_convert_case(Carbon::now()->translatedFormat('F'), MB_CASE_TITLE, 'UTF-8');
        
        $currentRepairs = $this->repairService->getRepairs();
        $endedRepairs = $this->repairService->getMonthlyEndedRepairs();
        $unclaimedOrders = $this->orderService->getUnlcaimedOrders();
        $calendarItems = $this->calendarService->getAllCalendarItems();

        return view('dashboards.dashboard', 
        [
            'title' => $title, 
            'currentRepairs' => $currentRepairs, 
            'endedRepairs' => $endedRepairs, 
            'currentMonth' => $currentMonth, 
            'orders' => $unclaimedOrders, 
            'calendarItems' => $calendarItems,
        ]);
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