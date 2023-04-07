<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/4
 * Time:  23:08
 */

namespace app\Controller\api;

use app\Controller\common\RedisCache;

class IndexController
{
    public function index()
    {
       $redisTest =  new  RedisCache();
       var_dump($redisTest->getRedisInstance());
    }
}