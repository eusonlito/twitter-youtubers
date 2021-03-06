<?php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'fetch' => PDO::FETCH_OBJ,

    'migrations' => 'migrations',

    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'port'      => env('DB_PORT', 3306),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => env('DB_PREFIX', ''),
            'strict'    => false
        ],
    ]
];
