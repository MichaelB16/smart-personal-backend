<?php

namespace App\Services;


class DashboardService
{
    public function __construct(protected StudentService $studentService) {}

    public function getSummary()
    {
        return [
            'student' => $this->studentService->getSummary(),
        ];
    }
}
