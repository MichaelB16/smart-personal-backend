<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginGoogleRequest;
use App\Http\Requests\LoginRequest;
use App\Services\Mails\SendEmailWelcomeService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(
        protected  UserService $userService,
        protected SendEmailWelcomeService $sendEmailWelcomeService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::guard('web')->attempt($credentials)) {
            $user = $this->userService->getByEmail($credentials['email']);

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer'
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function loginGoogle(LoginGoogleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->getByEmail($data['email']);

        $isNew = !$user;

        $user = $this->userService->updateOrCreate([
            ...$data,
            'is_google' => 1
        ]);

        if (Auth::guard('web')->loginUsingId($user->id)) {

            if ($isNew) {
                $this->sendEmailWelcomeService->send([
                    'email' => $user->email,
                    'username' => $user->name,
                ]);
            }

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer'
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
