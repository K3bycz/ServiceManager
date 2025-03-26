<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Client;
use App\Models\Repair;
use App\Services\RepairService;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{
    protected $repairService;

    public function __construct(RepairService $repairService)
    {
        $this->repairService = $repairService;
    }

    public function showDashboard(){
        $title ='Pulpit';
        $currentRepairs = $this->repairService->getMonthlyRepairs();
        $endedRepairs = $this->repairService->getMonthlyEndedRepairs();

        return view('dashboards.dashboard', ['title' => $title, 'currentRepairs' => $currentRepairs, 'endedRepairs' => $endedRepairs]);
    }

    public function showStatistics(){
        $title ='Statystyki';
    
        return view('dashboards.stats', ['title' => $title]);
    }

}