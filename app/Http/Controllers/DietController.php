<?php

namespace App\Http\Controllers;

use App\Http\Requests\DietGenerateRequest;
use App\Http\Requests\DietRequest;
use App\Services\DietService;

class DietController extends Controller
{
    public function __construct(protected DietService $dietService) {}

    public function generateDiet(DietGenerateRequest $request)
    {
        $data = $request->validated();

        $result = $this->dietService->generate($data);

        return response()->json($result);
    }

    public function saveDiet(DietRequest $request)
    {
        $data = $request->validated();

        $diet = $this->dietService->createDiet($data);

        return response()->json([
            'message' => 'Training save successfully',
            'data' => $diet
        ]);
    }
}
