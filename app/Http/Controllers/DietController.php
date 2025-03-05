<?php

namespace App\Http\Controllers;

use App\Http\Requests\DietGenerateRequest;
use App\Http\Requests\DietRequest;
use App\Services\DietService;
use Barryvdh\DomPDF\Facade\Pdf;

class DietController extends Controller
{
    public function __construct(protected DietService $dietService) {}

    public function pdf($id)
    {
        $diet = $this->dietService->getDiet($id);

        $pdf = Pdf::loadView('pdf.diet', [
            'listDiet' => json_decode($diet->diet),
            'coach' => $diet->user->name,
            'student' => $diet->student_name,
            'logo' => null
        ])->output();

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
