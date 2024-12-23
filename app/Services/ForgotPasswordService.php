<?php

namespace App\Services;


class ForgotPasswordService
{
    public function __construct(protected UserService $userService) {}

    public function checkEmailIsValid(string $email)
    {
        return  $this->userService->getByEmail($email);
    }
}
