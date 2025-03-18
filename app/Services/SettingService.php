<?php

namespace App\Services;

class SettingService
{
    public function __construct(protected UserService $userService, protected StudentService $studentService) {}

    public function getSetting()
    {
        $isPersonal = optional(auth('sanctum')->user())->type === 'personal';

        $service = $isPersonal ? $this->userService : $this->studentService;

        $result = $service->find(get_user_id());

        return [
            'user' => [
                'name' => $result->name,
                'email' => $result->email,
                'phone' => $result->phone,
                'logo' => optional($result)->logo ? get_file_path($result->logo) : '',
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
