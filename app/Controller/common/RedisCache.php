<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/6
 * Time:  17:58
 */

namespace app\Controller\common;


use libs\core\NosqlLib\NosqlFactory;
use libs\core\NosqlLib\Redis;

class RedisCache
{
    /**
     * 获取默认的redis实例
     * @return mixed
     */
    public function getRedisInstance()
    {
        //实例化Redis
        $Redis = NosqlFactory::factory('Redis');
        $Redis->set('111','4454');
        $Redis->lpush('ageaa','list');
        $Redis->lpush('ssss','4545');
        $Redis->select(7);
        $Redis->hSet('user', 'name', 'haiyang');
        var_dump($Redis->hGet('user', 'haiyang'));
        var_dump($Redis->hGet('user', 'name'));
        $Redis->hMset('users', ['name' => 'ceshi', 'age' => 26]);
    }
}