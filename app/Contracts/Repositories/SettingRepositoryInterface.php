<?php

namespace App\Contracts\Repositories;

interface SettingRepositoryInterface
{
    public function getSetting();
    public function setConfiguration(array $data);
}
