<?php

namespace App\Repositories;

use App\Contracts\Repositories\TrainingRepositoryInterface;
use App\Models\Training;

class TrainingRepository extends BaseRepository implements TrainingRepositoryInterface
{
    public function __construct(protected Training $training)
    {
        parent::__construct($training);
    }

    public function findTraining(int $id)
    {
        return $this->training
            ->join('students', function ($query) {
                $query->on('students.id', '=', 'training.student_id');
            })
            ->with(['user'])
            ->where(['student_id' => $id])
            ->select('training.*', 'students.name as student_name')
            ->first();
    }

    public function updateOrCreate(array $data)
    {
        return $this->training->create(
            [
                'student_id' => $data['student_id']
            ],
            [
                'training' => $data['training'],
                'student_id' => $data['student_id'],
                'user_id' => get_user_id(),
            ]
        );
    }
}
