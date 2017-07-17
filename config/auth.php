<?php
return [
    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],
    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver'   => 'token',
            'provider' => 'users',
        ],
        'customer' => [
            'driver'   => 'session',
            'provider' => 'customer'
        ]
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'customer' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class
        ]
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'email' => 'auth.emails.password',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'customer' => [
            'provider' => 'customer',
            'email' => 'auth.emails.password',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],
];