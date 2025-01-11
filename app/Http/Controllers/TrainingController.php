<?php

namespace App\Http\Controllers;

use App\Services\GeminiAiService;
use App\Services\TrainingService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function __construct(protected GeminiAiService $geminiAiService, protected TrainingService $trainingService) {}

    public function generateTraining(Request $request)
    {
        $data = $request->validate([
            'objective' => 'required',
            'sex' => 'required',
        ]);

        $data = $this->trainingService->generateTraining($data);

        return response()->json($data);
    }

    public function saveTraining(Request $request)
    {
        $data = $request->validate([
            'training' => 'required',
            'student_id' => 'required'
        ]);

        $training = $this->trainingService->createTraining($data);

        return response()->json([
            'message' => 'Training save successfully',
            'data' => $training
        ]);
    }
}
