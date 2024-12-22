<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->userService->create($data);

        if ($result) {

        }

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $result
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $result = $this->userService->find($id);

        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, string $id)
    {
        $data = $request->validated();

        $result = $this->userService->update($id, $data);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data' => $result
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $result = $this->userService->delete($id);

        return response()->json([
            'message' => 'successfully deleted',
            'data' => $result
        ]);
    }
}
