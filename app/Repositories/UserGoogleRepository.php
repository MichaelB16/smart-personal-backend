<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserGoogleRepositoryInterface;
use App\Models\UsersGoogle;

class UserGoogleRepository implements UserGoogleRepositoryInterface
{
    public function __construct(protected UsersGoogle $model) {}

    public function createOrUpdate(array $data)
    {
        return $this->model->updateOrCreate(
            [
                'user_id' => $data['user_id'],
            ],
            [
                'google_access_token' => $data['google_access_token'],
                'picture' => $data['picture'],
                'sub' => $data['sub'],
            ]
        );
    }
}
