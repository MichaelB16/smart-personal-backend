<?php

namespace App\Services;

use App\Enums\TYPE_FORMAT;
use App\Models\Training;

class DietService
{
    public function __construct(protected Training $training, protected GeminiAiService $geminiAiService) {}


    public function generate() {

      //  $prompt = 'criar uma dieta semanal com o objetivo de ganho de massa muscular para uma pessoa do sexo feminino com um custo de até 500 reais retorno um json array com dias e as refeicòes as fazer';

        $prompt = "Crie um JSON detalhado para um plano alimentar semanal vegano, com foco em alta ingestão de fibras, para uma mulher de 80kg com o objetivo de emagrecer. O JSON deve incluir informações nutricionais completas (calorias, macronutrientes, micronutrientes), sugestões de preparo e preferencialmente alimentos orgânicos. A estrutura deve incluir um objeto principal para o plano, seguido de um array de dias, cada dia com um array de refeições, e cada refeição com um array de alimentos. Além disso, gostaria de incluir um campo 'source' para indicar a origem do alimento e um campo 'recipe' para receitas completas. O JSON deve permitir o cálculo automático das calorias diárias e a geração de uma lista de compras personalizada.";

        $response = $this->geminiAiService->sendMessage($prompt, TYPE_FORMAT::JSON->value);

        return $response;

    }

    public function createDiet(array $data)
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
