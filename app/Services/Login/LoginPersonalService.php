<?php

namespace App\Services\Login;

use App\Contracts\LoginInterface;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class LoginPersonalService implements LoginInterface
{
    public function __construct(protected UserService $userService) {}

    public function login(array $credentials)
    {
        if (Auth::guard('web')->attempt($credentials)) {
            $user = $this->userService->getByEmail($credentials['email']);

            return [
                'user' => $user,
                'type' => 'personal',
                'token' => $user->createToken('personal_auth_token')->plainTextToken,
                'token_type' => 'Bearer'
            ];
        }

        return null;
    }
}
