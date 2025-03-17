<?php

if (!function_exists('get_menu_personal')) {
    function get_menu_personal()
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
            ],
            [
                'label' => 'Configurações',
                'icon' => 'mdi-cog-outline',
                'to' => $prefix . 'settings',
            ]
        ];
    }
}


if (!function_exists('get_menu_student')) {
    function get_menu_student()
    {
        $prefix = '/student/';
        return [
            [
                'label' => 'Área do Aluno',
                'icon' => 'mdi-speedometer',
                'to' => $prefix . 'dashboard',
            ]
        ];
    }
}
