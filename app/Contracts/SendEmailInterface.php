<?php

namespace App\Contracts;

interface SendEmailInterface
{
    public function send(array $data);
}
