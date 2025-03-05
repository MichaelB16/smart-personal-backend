<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingGenerateRequest;
use App\Http\Requests\TrainingRequest;
use App\Services\GeminiAiService;
use App\Services\TrainingService;
use Barryvdh\DomPDF\Facade\Pdf;

class TrainingController extends Controller
{
    public function __construct(protected GeminiAiService $geminiAiService, protected TrainingService $trainingService) {}

    public function pdf($id)
    {
        $training = $this->trainingService->getTraining($id);

        $filename = $training->student_name . '-treino.pdf';

        $data = [
            'listTraining' => json_decode($training->training),
            'coach' => $training->user->name,
            'student' => $training->student_name,
            'logo' => null
        ];

        $pdf = Pdf::loadView('pdf.training', $data)->output();

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

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
