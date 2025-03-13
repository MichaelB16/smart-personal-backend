<?php

namespace App\Services\Login;

use App\Contracts\LoginInterface;
use App\Services\Mails\SendEmailWelcomeService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class LoginGoogleService implements LoginInterface
{
    public function __construct(
        protected UserService $userService,
        protected SendEmailWelcomeService $sendEmailWelcomeService
    ) {}

    public function login(array $data): ?array
    {
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

            return [
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
                'type' => 'personal',
                'token_type' => 'Bearer'
            ];
        }

        return null;
    }
}
