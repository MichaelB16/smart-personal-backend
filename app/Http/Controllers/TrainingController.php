<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingGenerateRequest;
use App\Http\Requests\TrainingRequest;
use App\Services\GeminiAiService;
use App\Services\TrainingService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function __construct(protected GeminiAiService $geminiAiService, protected TrainingService $trainingService) {}

    public function generateTraining(TrainingGenerateRequest $request)
    {
        $data = $request->validated();

        $data = $this->trainingService->generateTraining($data);

        return response()->json($data);
    }

    public function saveTraining(TrainingRequest $request)
    {
        $data = $request->validated();

        $training = $this->trainingService->createTraining($data);

        return response()->json([
            'message' => 'Training save successfully',
            'data' => $training
        ]);
    }
}
