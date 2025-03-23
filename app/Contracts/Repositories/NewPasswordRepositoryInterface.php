<?php

namespace App\Contracts\Repositories;

interface NewPasswordRepositoryInterface
{
    public function checkToken($token);
    public function create(array $data);
    public function delete(int $user_id);
}
