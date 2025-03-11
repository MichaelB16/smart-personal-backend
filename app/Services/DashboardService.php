<?php

namespace App\Services;

use App\Models\Diet;
use App\Models\Training;

class DashboardService
{
    public function __construct(protected StudentService $studentService, protected Training $training, protected Diet $diet) {}

    public function getSummary()
    {
        return [
            'student' => $this->studentService->getSummary(),
        ];
    }

    public function getStudentDashboard()
    {
        $where = ['student_id' => auth('sanctum')->user()->id];

        $resultTraining = $this->training->where($where)->first(['training']);
        $resultDiet = $this->diet->where($where)->first(['diet']);

        $diet = optional($resultDiet)->diet ? json_decode($resultDiet->diet) : [];
        $training = optional($resultTraining)->training ? json_decode($resultTraining->training) : [];

        return [
            'today_diet' => [],
            'today_training' => [],
            'weekly_diet' => $diet,
            'weekly_training' =>  $training,
        ];
    }
}
