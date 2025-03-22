<?php

namespace App\Contracts\Repositories;


interface TrainingRepositoryInterface
{
    public function findTraining(int $id);
    public function updateOrCreate(array $data);
}
