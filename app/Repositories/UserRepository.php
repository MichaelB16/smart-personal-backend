<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(protected User $user)
    {
        parent::__construct($user);
    }

    public function updateOrCreate(array $where, array $data)
    {
       return $this->user->updateOrCreate($where, $data);
    }
}
