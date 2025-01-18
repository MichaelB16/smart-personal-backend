<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function __construct(protected StudentService $studentService) {}

    public function index(Request $request): JsonResponse
    {
        $search = $request->get('search') ?? '';

        $result = $this->studentService->getAll($search);

        return response()->json($result);
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
