<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/26
 * Time: 23:01
 */

namespace app\Middleware;

use libs\core\Middleware\Middleware;

class UserMiddleware extends Middleware
{
    public function handle()
    {
        echo 'user Middleware';
        return $this->next();
    }
}