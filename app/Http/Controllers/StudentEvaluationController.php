<?php

namespace App\Http\Controllers;

use App\Services\StudentEvaluationService;

class StudentEvaluationController extends Controller
{
    public function __construct(protected StudentEvaluationService $studentEvaluationService) {}

    public function index()
    {
        $result = $this->studentEvaluationService->getStudentEvaluation();

        return response()->json($result);
    }
}
