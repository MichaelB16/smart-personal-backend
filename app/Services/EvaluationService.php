<?php

namespace App\Services;

use App\Contracts\Repositories\EvaluationRepositoryInterface;

class EvaluationService
{
    public function __construct(protected EvaluationRepositoryInterface $repository) {}

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
