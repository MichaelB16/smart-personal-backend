<?php

namespace App\Repositories;

use App\Contracts\Repositories\SettingRepositoryInterface;
use App\Services\StudentService;
use App\Services\UserService;

class SettingRepository implements SettingRepositoryInterface
{
    protected $service;

    public function __construct(
        protected UserService $userService,
        protected StudentService $studentService
    ) {
        $this->service = get_is_personal() ? $this->userService : $this->studentService;
    }

    public function getSetting()
    {
        $result = $this->service->find(get_user_id());

        return [
            'user' => [
                'name' => $result->name,
                'email' => $result->email,
                'phone' => $result->phone,
                'logo' => optional($result)->logo ? get_file_path($result->logo) : '',
            ],
            'menu' => get_is_personal() ? get_menu_personal() : get_menu_student()
        ];
    }

    public function setConfiguration(array $data)
    {
        return $this->service->update(get_user_id(), $data);
    }
}
