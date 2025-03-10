<?php

namespace App\Http\Controllers;

use App\Services\NewPasswordService;
use App\Services\StudentService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NewPasswordController extends Controller
{
    public function __construct(
        protected NewPasswordService $newPasswordService,
        protected StudentService $studentService,
        protected UserService $userService
    ) {}

    public function checkToken($token): JsonResponse
    {
        $result = $this->newPasswordService->checkToken($token);

        if ($result && $result->id) {
            return response()->json($result);
        }

        return response()->json([
            'error' => 'token_not_found',
            'message' => 'token not found!'
        ], 404);
    }

    public function updatePassword(Request $request, $id)
    {
        $data = $request->validate(['password' => 'required']);

        $student = $this->studentService->getById($id);

        $params = [
            'password' => Hash::make($data['password'])
        ];

        if ($student) {
            $this->studentService->updateWithoutScope($id, $params);
        } else {
            $this->userService->update($id, $params);
        }

        $this->newPasswordService->deleteToken($id);

        return response()->json([
            'message' => 'Student updated successfully.',
        ]);
    }
}
