<?php

namespace App\Services;

use App\Contracts\Repositories\TrainingRepositoryInterface;

class TrainingService
{
    public function __construct(
        protected TrainingRepositoryInterface $repository,
        protected GeminiAiService $geminiAiService
    ) {}

    public function getTraining(int $id)
    {
        return $this->repository->findTraining($id);
    }

    public function getVideoTraining(array $listTraining)
    {
        $links = [];
        if (count($listTraining) > 0) {
            foreach ($listTraining as $training) {
                $prompt = 'Me retorne exatamente dois vídeos do YouTube Shorts, reais e disponíveis publicamente, relacionados ao exercício ' . $training . ', no formato embed pronto para uso em <iframe>';
                $response = $this->geminiAiService->sendMessage($prompt, 'json');
                array_push($links, $response);
            }
        }
        return $links;
    }

    public function generateTraining(array $data)
    {
        $prompt = "Quero um treino semanal para " . $data['objective'] . " para uma pessoa do sexo" . $data['sex'] . " como um array de objetos, onde cada objeto contém o day (dia da semana), focus (grupos musculares principais, ex: 'Peito/Tríceps') e um array exercises com objetos contendo name (nome do exercício), repeat (repetições ou intervalo, ex: '8-12'), series (número de séries) e focus (músculo específico trabalhado, ex: 'Peitoral Maior').";

        $response = $this->geminiAiService->sendMessage($prompt, 'json');

        return $response;
    }

    public function createTraining(array $data)
    {
        return $this->repository->updateOrCreate($data);
    }
}
