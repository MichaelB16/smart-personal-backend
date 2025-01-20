<?php

namespace App\Services;

use App\Enums\TYPE_FORMAT;
use App\Models\Diet;

class DietService
{
    public function __construct(protected Diet $diet, protected GeminiAiService $geminiAiService) {}


    public function generate(array $data)
    {
        $objective = $data['objective'];
        $sex = $data['sex'];
        $value = $data['price'];
        $restriction = !empty($data['restriction']) ? 'e com restrições em '.$data['restriction'] : '';

        $prompt = 'criar uma dieta semanal com o objetivo de' . $objective . 'para uma pessoa do sexo ' . $sex . ' com um custo de até ' . $value . ' reais '. $restriction.' retorno um json array com dias e as refeicões as fazer dia com (day) e refeicões como (meals) e descricão como (description) na descrição crie tambem uma label para cada tipo de refeição exemplo (labe:Café da manhã)';

        $response = $this->geminiAiService->sendMessage($prompt, TYPE_FORMAT::JSON->value);

        return $response;
    }

    public function createDiet(array $data)
    {
        return $this->diet->updateOrCreate(
            [
                'student_id' => $data['student_id']
            ],
            [
                'diet' => $data['diet'],
                'student_id' => $data['student_id'],
                'user_id' => auth()->id(),
            ]
        );
    }
}
