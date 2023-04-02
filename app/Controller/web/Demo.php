<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/29
 * Time: 23:07
 */

namespace app\Controller\web;

use libs\core\CoreController;

class Demo extends CoreController
{
    /**
     * @return void
     * redis 字符串
     */
        public function stringRedis()
        {
            new \Redis();
        }
}