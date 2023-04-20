<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/24
 * Time: 22:49
 */
return [
//    '\app\Controller\web\UserController' => \app\Controller\common\Log::class,
//    '\app\Controller\admin\LoginController' => \app\Controller\common\Log::class,
    '\app\Controller\admin\LoginController\reateTimesheet' => \app\Controller\common\RefreshRedisToken::class,
//    '\app\Controller\admin\IndexController' => \app\Controller\common\Log::class,
//    '\app\Controller\web\IndexController' => \app\Controller\common\Log::class,
];