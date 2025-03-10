<?php

namespace App\Http\Controllers;

use App\Http\Requests\DietGenerateRequest;
use App\Http\Requests\DietRequest;
use App\Services\DietService;
use App\Services\Pdf\DietPdfService;

class DietController extends Controller
{
    public function __construct(protected DietService $dietService, protected DietPdfService $dietPdfService) {}

    public function pdf($id)
    {
        $diet = $this->dietService->getDiet($id);

        $pdf = $this->dietPdfService->generatePdf([
            'listDiet' => json_decode($diet->diet),
            'coach' => $diet->user->name,
            'student' => $diet->student_name,
            'logo' => null
        ]);

        return response($pdf)->header('Content-Type', 'application/pdf');
    }

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
