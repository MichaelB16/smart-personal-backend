<?php

namespace App\Services;

use App\Models\Training;

class TrainingService
{
    public function __construct(protected Training $training,  protected GeminiAiService $geminiAiService) {}

    public function getTraining(int $id)
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

    public function generateTraining(array $data)
    {
        $prompt = "Quero um JSON que representa um treino semanal para " . $data['objective'] . " " . $data['sex'] . " como um array de objetos, onde cada objeto contém o day (dia da semana), focus (grupos musculares principais, ex: 'Peito/Tríceps') e um array exercises com objetos contendo name (nome do exercício), repeat (repetições ou intervalo, ex: '8-12'), series (número de séries) e focus (músculo específico trabalhado, ex: 'Peitoral Maior').";

        $response = $this->geminiAiService->sendMessage($prompt, 'json');

        return $response;
    }

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
