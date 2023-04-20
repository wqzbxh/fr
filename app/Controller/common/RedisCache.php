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
    public $redis;
    public function __construct()
    {
        $this->redis = NosqlFactory::factory('Redis');
    }

    /**
     * @param $key
     * @param $data
     * @return void
     * 设置用户信息到redis中
     */
    public function setTTUserInfo($key,$data)
    {
        $this->redis->select(1);
        $this->redis->hSet($key, 'username',$data['username']);
        $this->redis->hSet($key, 'email', $data['email']);
        $this->redis->expire($key, 1200);
    }

    public function getRedisInstance()
    {
        return $this->redis;
    }

    /**
     * 删除key
     */
    public function del($key)
    {
        $this->redis->select(1);
        return $this->redis->del($key);
    }
}