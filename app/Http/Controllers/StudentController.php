<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Services\GeminiAiService;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(protected StudentService $studentService, protected GeminiAiService $geminiAiService) {}

    public function index(Request $request): JsonResponse
    {
        $search = $request->get('search') ?? '';

        $result = $this->studentService->getAll($search);

        return response()->json($result);
    }


    public function generateTraining(Request $request)
    {
        $data = $request->validate([
            'objective' => 'required',
            'sex' => 'required',
        ]);

        $prompt = "Quero um JSON que representa um treino semanal para ".$data['objective']." ".$data['sex']." como um array de objetos, onde cada objeto contém o day (dia da semana), focus (grupos musculares principais, ex: 'Peito/Tríceps') e um array exercises com objetos contendo name (nome do exercício), repeat (repetições ou intervalo, ex: '8-12'), series (número de séries) e focus (músculo específico trabalhado, ex: 'Peitoral Maior').";

        $response = $this->geminiAiService->sendMessage($prompt);

        $json_string = trim(preg_replace('/^\`\`\`json\n|\n\`\`\`$/', '', $response));

        $data = json_decode($json_string);

        return response()->json($data);
    }


    public function store(StudentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->studentService->create($data);

        return response()->json([
            'message' => 'Student created successfully.',
            'data' => $result
        ]);
    }

    public function show($id): JsonResponse
    {
        $result = $this->studentService->getById($id);

        return response()->json($result);
    }

    public function update(StudentRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $result = $this->studentService->update($id, $data);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data' => $result
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->studentService->delete($id);

        return response()->json([
            'message' => 'successfully deleted',
            'data' => $result
        ]);
    }
}
