<?php

namespace App\Contracts\Repositories;

interface ForgotRepositoryInterface
{
    public function checkEmailIsValid(string $email);
}
