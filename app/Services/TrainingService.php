<?php

namespace App\Services;

use App\Models\Training;

class TrainingService
{
    public function __construct(protected Training $training) {}

    public function createTraining(array $data)
    {
        return $this->training->updateOrCreate(
            [
                'student_id' => $data['student_id']
            ],
            [
                'training' => $data['training'],
                'student_id' => $data['student_id'],
                'user_id' => auth()->id(),
            ]
        );
    }
}
