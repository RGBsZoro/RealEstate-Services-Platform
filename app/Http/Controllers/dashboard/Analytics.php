<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Services\Web\DashboardService;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function __construct(protected DashboardService $dashboard) {}
  public function index()
  {
    $stats = $this->dashboard->getStatistics();
    return view('content.dashboard.dashboards-analytics', compact('stats'));
  }
}
