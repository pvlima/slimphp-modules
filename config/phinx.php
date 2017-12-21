<?php

require __DIR__ . '/../helpers/helpers.php';

return [

    'paths' => [
        'migrations' => load_modules('/db/migrations'),
        'seeds' => load_modules('/db/seeds')
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8'
        ],

        'development' => [
            'adapter' => 'mysql',
            'host' => 'mysql',
            'name' => 'spotoyou_master',
            'user' => 'root',
            'pass' => 'spotoyou',
            'port' => '3306',
            'charset' => 'utf8'
        ],

        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8'
        ]
    ],

    'version_order' => 'creation'
];