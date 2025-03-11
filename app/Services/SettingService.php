<?php

namespace App\Services;

class SettingService
{
    public function getSetting()
    {
        $isPersonal = optional(auth('sanctum')->user())->type === 'personal';

        return [
            'menu' => $isPersonal ? $this->getMenuPersonal() : $this->getMenuStudent()
        ];
    }

    protected function getMenuPersonal()
    {
        $prefix = '/personal/';

        return [
            [
                'label' => 'Dashboard',
                'icon' => 'mdi-speedometer',
                'to' => $prefix . 'dashboard',
            ],
            [
                'label' => 'Alunos',
                'icon' => 'mdi-account-group-outline',
                'to' => $prefix . 'students',
            ],
            [
                'label' => 'Agenda',
                'icon' => 'mdi-calendar-outline',
                'to' => $prefix . 'calendar',
            ],
            [
                'label' => 'Mensagens',
                'icon' => 'mdi-message-outline',
                'to' => $prefix . 'message',
            ]
        ];
    }

    protected function getMenuStudent()
    {
        $prefix = '/student/';

        return [
            [
                'label' => 'Dashboard',
                'icon' => 'mdi-speedometer',
                'to' => $prefix . 'dashboard',
            ]
        ];
    }
}
