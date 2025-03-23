<?php

namespace App\Services;

use App\Contracts\Repositories\NewPasswordRepositoryInterface;

class NewPasswordService
{
    public function __construct(protected NewPasswordRepositoryInterface $repository) {}

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function checkToken(string $token)
    {
        return $this->repository->checkToken($token);
    }

    public function deleteToken($user_id)
    {
        return $this->repository->delete($user_id);
    }
}
