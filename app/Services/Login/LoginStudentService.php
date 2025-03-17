<?php

namespace App\Services\Login;

use App\Contracts\LoginInterface;
use App\Services\StudentService;
use Illuminate\Support\Facades\Auth;

class LoginStudentService implements LoginInterface
{
    public function __construct(protected StudentService $studentService) {}

    public function login(array $credentials): ?array
    {
        if (Auth::guard('students')->attempt($credentials)) {
            $student = $this->studentService->getByEmail($credentials['email']);

            return [
                'user' => [
                    ...$student->toArray(),
                    'type' => 'student',
                ],
                'type' => 'student',
                'token' => $student->createToken('student_auth_token')->plainTextToken,
                'token_type' => 'Bearer'
            ];
        }

        return null;
    }
}
