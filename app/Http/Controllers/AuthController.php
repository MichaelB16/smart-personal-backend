<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(protected  UserService $userService) {
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $this->userService->getByEmail($credentials['email']);

        return response()->json([
            'user' => Auth::user(),
            'token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer'
        ]);
    }

    public function loginGoogle(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'sub' => 'required|string',
            'picture' => 'nullable|string',
        ]);

       $user = $this->userService->updateOrCreate([
           ...$data,
           'is_google' => 1
       ]);

       if (Auth::guard('web')->loginUsingId($user->id)) {
           return response()->json([
               'user' => Auth::user(),
               'token' => $user->createToken('auth_token')->plainTextToken,
               'token_type' => 'Bearer'
           ]);
       }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'logout successfull']);
    }
}
