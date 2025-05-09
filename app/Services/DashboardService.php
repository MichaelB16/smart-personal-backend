<?php

namespace App\Services;

use App\Models\Diet;
use App\Models\Training;
use Carbon\Carbon;

class DashboardService
{
    public function __construct(
        protected StudentService $studentService,
        protected TrainingService $trainingService,
        protected Training $training,
        protected Diet $diet
    ) {}

    public function getSummary()
    {
        return [
            'student' => $this->studentService->getSummary(),
        ];
    }

    public function getStudentDashboard()
    {
        $resultTraining = $this->training
            ->where(['student_id' => get_user_id()])
            ->first(['training']);

        $resultDiet = $this->diet
            ->where(['student_id' => get_user_id()])
            ->first(['diet']);

        Carbon::setLocale('pt_BR');

        $now = Carbon::now();
        $day = $now->isoFormat('dddd');

        $diet = optional($resultDiet)->diet ? json_decode($resultDiet->diet) : [];
        $training = optional($resultTraining)->training ? json_decode($resultTraining->training) : [];

        $trainingToday = array_filter($training, function ($item) use ($day) {
            return strtolower($item->day) === strtolower($day);
        });

        $trainingName = array_map(function ($item) {
            return array_map(function ($exercise) {
                return $exercise->name;
            }, $item->exercises);
        }, $trainingToday);


        $videos = $this->trainingService->getVideoTraining(...$trainingName);

        $dietToday = array_filter($diet, function ($item) use ($day) {
            return strtolower($item->day) === strtolower($day);
        });

        return [
            'today_diet' => $dietToday,
            'today_training' => $trainingToday,
            'weekly_diet' => $diet,
            'weekly_training' =>  $training,
            'videos' => $videos,
        ];
    }
}
