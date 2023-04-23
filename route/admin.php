<?php

/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/4/2
 * Time: 1:34
 */

use libs\core\Router;

Router::add('login','admin/login/login')->middleware(\app\Middleware\AuthorizationMiddleware::class);
Router::add('logout','admin/login/logout');

Router::add('create_timesheet','admin/login/reateTimesheet');