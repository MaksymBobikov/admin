<?php

return [
    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],
    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => Maksb\Admin\Models\AdminUser::class,
        ],
    ],
    'passwords' => [
        'admin_users' => [
            'provider' => 'admin_users',
            'table' => 'admin_password_resets',
            'expire' => 60,
        ],
    ],
];
