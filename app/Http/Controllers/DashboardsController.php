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
        $repairs = $this->repairService->getMonthlyRepairs();

        return view('dashboards.dashboard', ['title' => $title, 'repairs' => $repairs]);
    }

}