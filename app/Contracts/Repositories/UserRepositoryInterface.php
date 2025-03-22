<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getByEmail($email);
    public function getBySub($sub);
    public function updateOrCreate(array $where, array $data);
}
