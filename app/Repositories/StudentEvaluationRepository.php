<?php

namespace App\Repositories;

use App\Contracts\Repositories\StudentEvaluationRepositoryInterface;
use App\Models\Evaluation;
use Carbon\Carbon;

class StudentEvaluationRepository implements StudentEvaluationRepositoryInterface
{
    public function __construct(protected Evaluation $model) {}

    public function findAll()
    {
        $query = $this->model->where(['student_id' => get_user_id()]);

        $months = (clone $query)
            ->whereDate('created_at', '<', Carbon::now()->startOfMonth())
            ->get();

        $actual = (clone $query)
            ->whereMonth('created_at', Carbon::now('America/Sao_Paulo')->month)
            ->whereYear('created_at', Carbon::now('America/Sao_Paulo')->year)
            ->first();

        return [
            'evalation_months' => $months,
            'evaluation_actual' => $actual
        ];
    }
}
