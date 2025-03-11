<?php

namespace App\Services;

use App\Contracts\SendEmailInterface;
use App\Jobs\SendForgotPasswordEmail;

class SendEmailForgotPasswordService implements SendEmailInterface
{
    public function send(array $data)
    {
        SendForgotPasswordEmail::dispatch([
            'email' => $data['email'],
            'user_id' => $data['user_id'],
            'username' => $data['username']
        ]);
    }
}
