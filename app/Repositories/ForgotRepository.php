<?php

namespace App\Repositories;

use App\Contracts\Repositories\ForgotRepositoryInterface;
use App\Services\StudentService;
use App\Services\UserService;

class ForgotRepository implements ForgotRepositoryInterface
{
    public function __construct(protected UserService $userService, protected StudentService $studentService) {}

    public function checkEmailIsValid(string $email)
    {
        $isEmailStudent = $this->studentService->getByEmail($email);
        if ($isEmailStudent) {
            return $isEmailStudent;
        }
        return $this->userService->getByEmail($email);
    }
}
