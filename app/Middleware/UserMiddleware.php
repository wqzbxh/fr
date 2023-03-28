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
        echo "<h1>您已经经过中间件拦截</h1>";
        return $this->next();
    }
}