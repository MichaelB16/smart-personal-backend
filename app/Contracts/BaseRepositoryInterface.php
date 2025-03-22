<?php

namespace App\Contracts;

interface BaseRepositoryInterface
{
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
