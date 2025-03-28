<?php

namespace App\Repositories;

use App\Contracts\Repositories\EvaluationRepositoryInterface;
use App\Models\Evaluation;

class EvaluationRepository implements EvaluationRepositoryInterface
{
    public function __construct(protected Evaluation $model) {}

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }
}
