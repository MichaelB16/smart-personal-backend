<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingGenerateRequest;
use App\Http\Requests\TrainingRequest;
use App\Services\GeminiAiService;
use App\Services\TrainingService;
use App\Services\Pdf\TrainingPdfService;
use App\Services\UserService;

class TrainingController extends Controller
{
    public function __construct(
        protected GeminiAiService $geminiAiService,
        protected TrainingService $trainingService,
        protected UserService $userService,
        protected TrainingPdfService $trainingPdfService
    ) {}

    public function pdf($student_id)
    {
        $user = $this->userService->find(get_user_id());
        $training = $this->trainingService->getTraining($student_id);

        $params = [
            'listTraining' => json_decode($training->training),
            'coach' => $training->user->name,
            'student' => $training->student_name,
            'logo' => get_file_to_pdf($user->logo),
        ];

        $pdf = $this->trainingPdfService->generatePdf($params);

        return response($pdf)->header('Content-Type', 'application/pdf');
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
