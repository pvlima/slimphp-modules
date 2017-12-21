<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        "determineRouteBeforeAppMiddleware" => true,

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'db' => [
            'driver'    => config('environments.development.adapter'),
            'host'      => config('environments.development.host'),
            'database'  => config('environments.development.name'),
            'username'  => config('environments.development.user'),
            'password'  => config('environments.development.pass'),
            'charset'   => config('environments.development.charset'),
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ]
    ],
];
