<?php

namespace App\Services;

use App\Contracts\Repositories\UserGoogleRepositoryInterface;
use App\Models\UsersGoogle;

class UsersGoogleService
{
    public function __construct(protected UserGoogleRepositoryInterface $repository) {}

    public function createOrUpdate(array $data): UsersGoogle
    {
        return $this->repository->createOrUpdate($data);
    }
}
