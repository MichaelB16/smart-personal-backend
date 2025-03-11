<?php

namespace App\Services;

use App\Contracts\SendEmailInterface;
use App\Jobs\SendStudentCreatedEmail;

class SendEmailStudentCreatedService implements SendEmailInterface
{
    public function send(array $data)
    {
        SendStudentCreatedEmail::dispatch([
            'student_id' => $data['student_id'],
            'email' => $data['email'],
            'username' => $data['username'],
        ]);
    }
}
