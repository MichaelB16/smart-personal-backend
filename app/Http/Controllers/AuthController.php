<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginGoogleRequest;
use App\Http\Requests\LoginRequest;
use App\Services\Login\LoginGoogleService;
use App\Services\Login\LoginPersonalService;
use App\Services\Login\LoginStudentService;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(
        protected StudentService $studentService,
        protected LoginGoogleService $loginGoogleService,
        protected LoginStudentService $loginStudentService,
        protected LoginPersonalService $loginPersonalService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $student = $this->studentService->getByEmail($credentials['email']);

        $service = $student ? $this->loginStudentService : $this->loginPersonalService;

        $result = $service->login($credentials);

        if (is_null($result)) {
            return $this->unauthorizedResponse();
        }

        return response()->json($result);
    }

    public function loginGoogle(LoginGoogleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->loginGoogleService->login($data);

        if (is_null($result)) {
            return $this->unauthorizedResponse();
        }

        return response()->json($result);
    }

    private function unauthorizedResponse(): JsonResponse
    {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
