<?php

namespace App\Services;

use App\Contracts\Repositories\ForgotRepositoryInterface;

class ForgotPasswordService
{
    public function __construct(protected ForgotRepositoryInterface $repository) {}

    public function checkEmailIsValid(string $email)
    {
        return $this->repository->checkEmailIsValid($email);
    }
}
