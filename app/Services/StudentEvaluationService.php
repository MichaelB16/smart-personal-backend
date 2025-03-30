<?php

namespace App\Services;

use App\Contracts\Repositories\StudentEvaluationRepositoryInterface;

class StudentEvaluationService
{
    public function __construct(protected StudentEvaluationRepositoryInterface $repository) {}

    public function getStudentEvaluation()
    {
        return $this->repository->findAll();
    }
}
