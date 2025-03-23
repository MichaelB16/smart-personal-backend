<?php

namespace App\Services;

use App\Contracts\Repositories\SettingRepositoryInterface;

class SettingService
{
    public function __construct(protected SettingRepositoryInterface $repository) {}

    public function getSetting()
    {
        return $this->repository->getSetting();
    }

    public function setConfiguration(array $data)
    {
        return $this->repository->setConfiguration($data);
    }
}
