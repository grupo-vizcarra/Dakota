<?php

return [

    'default' => env('DB_CONNECTION', 'local'),
    'migrations' => 'migrations',
    'connections' => [
        'local' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'pass'),
            'username' => env('DB_USERNAME', 'user'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'engine' => env('DB_ENGINE', null),
        ],

        'AWS' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_AWS', 'localhost'),
            'port' => env('DB_PORT_AWS', '3306'),
            'database' => env('DB_DATABASE_AWS', 'pass'),
            'username' => env('DB_USERNAME_AWS', 'user'),
            'password' => env('DB_PASSWORD_AWS', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'engine' => env('DB_ENGINE', null),
        ],
    ],
];