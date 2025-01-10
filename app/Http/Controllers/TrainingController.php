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

        $prompt = "Quero um JSON que representa um treino semanal para " . $data['objective'] . " " . $data['sex'] . " como um array de objetos, onde cada objeto contém o day (dia da semana), focus (grupos musculares principais, ex: 'Peito/Tríceps') e um array exercises com objetos contendo name (nome do exercício), repeat (repetições ou intervalo, ex: '8-12'), series (número de séries) e focus (músculo específico trabalhado, ex: 'Peitoral Maior').";

        $response = $this->geminiAiService->sendMessage($prompt);

        $json_string = trim(preg_replace('/^\`\`\`json\n|\n\`\`\`$/', '', $response));

        $data = json_decode($json_string);

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
