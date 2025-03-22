<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(protected User $user)
    {
        parent::__construct($user);
    }

    public function updateOrCreate(array $where, array $data)
    {
        return $this->user->updateOrCreate($where, $data);
    }


    public function getBySub($sub)
    {
        return $this->user->where(['sub' => $sub])->first();
    }

    public function getByEmail($email)
    {
        return $this->user->where(['email' => $email])->first();
    }
}
