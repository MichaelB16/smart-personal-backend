<?php

namespace App\Contracts;

interface LoginInterface
{
    public function login(array $credentials): ?array;
}
