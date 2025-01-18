<?php

namespace App\Http\Controllers;

use App\Services\DietService;
use Illuminate\Http\Request;

class DietController extends Controller
{
    public function __construct(protected DietService $dietService) {}

    public function generateDiet()
    {
        $result = $this->dietService->generate();

        return response()->json($result);
    }
}
