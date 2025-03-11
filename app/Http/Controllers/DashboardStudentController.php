<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardStudentController extends Controller
{
    public function __construct(protected DashboardService $dashboardService) {}

    public function index()
    {
        $result = $this->dashboardService->getStudentDashboard();

        return response()->json($result);
    }
}
