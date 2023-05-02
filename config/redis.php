<?php
/**
 * Created by : phpstorm
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  21:04
 */
return [
    'redis' => [
        'host' => $_ENV['REDIS_HOST'] ?? '1.117.159.188',
        'port' => $_ENV['REDIS_PORT'] ?? '6379',
        'password' =>  $_ENV['REDIS_PASSWORD'] ?? 'admin123',
        'dbtabase' => $_ENV['REDIS_DATABASE'] ?? '127.0.0.1',
    ]
];