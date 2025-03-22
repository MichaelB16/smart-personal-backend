<?php

namespace App\Services\Login;

use App\Contracts\LoginInterface;
use App\Models\UsersGoogle;
use App\Services\Mails\SendEmailWelcomeService;
use App\Services\UserService;
use App\Services\UsersGoogleService;
use Illuminate\Support\Facades\Auth;

class LoginGoogleService implements LoginInterface
{
    public function __construct(
        protected UserService $userService,
        protected UsersGoogleService $usersGoogleService,
        protected SendEmailWelcomeService $sendEmailWelcomeService
    ) {}

    public function login(array $data): ?array
    {
        $newUser = !$this->userService->getByEmail($data['email']);

        $user = $this->userService->updateOrCreate([
            ...$data,
            'is_google' => 1
        ]);

        $this->usersGoogleService->createOrUpdate([
            ...$data,
            'user_id' => $user->id,
        ]);

        if ($newUser) {
            $this->sendEmailWelcomeService->send([
                'email' => $user->email,
                'username' => $user->name,
            ]);
        }

        if (Auth::guard('web')->loginUsingId($user->id)) {
            return [
                'user' => [
                    ...$user->toArray(),
                    'type' => 'personal'
                ],
                'token' => $user->createToken('auth_token')->plainTextToken,
                'type' => 'personal',
                'token_type' => 'Bearer'
            ];
        }

        return null;
    }
}
