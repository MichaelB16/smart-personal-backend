<?php

namespace App\Services\Mails;

use App\Contracts\SendEmailInterface;
use App\Jobs\SendNewPasswordEmail;

class SendEmailNewPasswordService implements SendEmailInterface
{
    public function send(array $data)
    {
        SendNewPasswordEmail::dispatch([
            'user_id' => $data['user_id'],
            'email' => $data['email'],
            'username' => $data['username'],
        ]);
    }
}
