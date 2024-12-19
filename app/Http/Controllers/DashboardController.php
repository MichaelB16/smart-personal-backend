<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService) {}

    public function summary()
    {
        $result = $this->dashboardService->getSummary();
        return response()->json($result);
    }
}
