<?php

namespace App\Contracts\Repositories;

interface UserGoogleRepositoryInterface
{
    public function createOrUpdate(array $data);
}
