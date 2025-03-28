<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationRequest;
use App\Services\EvaluationService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function __construct(protected EvaluationService $evaluationService) {}

    public function store(EvaluationRequest $request)
    {
        $data = $request->validated();

        $this->evaluationService->create($data);

        return response()->json([
            'message' => 'Evaluation created successfully'
        ], 201);
    }

    public function update(EvaluationRequest $request, $id)
    {
        $data = $request->validated();

        $this->evaluationService->update($id, $data);

        return response()->json([
            'message' => 'Evaluation updated successfully'
        ], 200);
    }
    public function destroy($id)
    {
        $this->evaluationService->delete($id);

        return response()->json([
            'message' => 'Evaluation deleted successfully'
        ], 200);
    }
}
