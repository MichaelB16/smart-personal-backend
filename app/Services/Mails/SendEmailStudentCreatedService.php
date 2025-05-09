<?php

namespace App\Services\Mails;

use App\Contracts\SendEmailInterface;
use App\Jobs\SendStudentCreatedEmail;

class SendEmailStudentCreatedService implements SendEmailInterface
{

    public function send(array $data)
    {
        SendStudentCreatedEmail::dispatch($data);
    }
}
