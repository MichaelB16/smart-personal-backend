<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\SendMailUser;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function __construct(protected  UserService $userService) {}

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);


        if(Auth::guard('web')->attempt($credentials)) {
            $user = $this->userService->getByEmail($credentials['email']);
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer'
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    protected function sendEmailWelcome($user)
    {
        try {
            Mail::to($user->email)->send(new SendMailUser(['username' => $user->name]));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function loginGoogle(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'sub' => 'required|string',
            'picture' => 'nullable|string',
        ]);


        $isNew = !$this->userService->getByEmail($data['email']);

        $user = $this->userService->updateOrCreate([
            ...$data,
            'is_google' => 1
        ]);

        if (Auth::guard('web')->loginUsingId($user->id)) {

            if($isNew) {
                $this->sendEmailWelcome($user);
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

        return response()->json(['message' => 'logout successfull']);
    }
}
