<?php

namespace App\Services;

class SettingService
{
    public function __construct(protected UserService $userService) {}

    public function getSetting()
    {
        $isPersonal = optional(auth('sanctum')->user())->type === 'personal';

        $result = $this->userService->find(auth('sanctum')->user()->id);

        return [
            'user' => [
                'name' => $result->name,
                'email' => $result->email,
                'phone' => $result->phone,
                'logo' => $result->logo ? get_file_path($result->logo) : '',
            ],
            'menu' => $isPersonal ? get_menu_personal() : get_menu_student()
        ];
    }

    public function setConfiguration(array $data)
    {
        $id = auth('sanctum')->user()->id;

        return $this->userService->update($id, $data);
    }
}
