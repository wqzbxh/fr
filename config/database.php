<?php
/**
 * Created by : phpstorm
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  21:04
 */
return [
    'mysql' => [
        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'port' => $_ENV['DB_PORT'] ?? '3307',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? 'root',
        'dbname' => $_ENV['DB_DATABASE'] ?? 'react'
    ]
];
