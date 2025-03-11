<?php

namespace App\Services\mails;

use App\Contracts\SendEmailInterface;
use App\Jobs\SendWelcomeEmail;

class SendEmailWelcomeService implements SendEmailInterface
{
    public function send(array $data)
    {
        SendWelcomeEmail::dispatch([
            'email' => $data['email'],
            'username' => $data['username'],
        ]);
    }
}
