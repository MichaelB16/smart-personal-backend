<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepositoryInterface;

interface StudentRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll(string $search = '');
    public function getSummary();
    public function getByEmail(string $email);
    public function updateWithoutScope(int $id, array $data);
}
