<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/6
 * Time:  15:32
 */

namespace libs\core\NosqlLib;

use libs\core\Config;
use libs\core\Message;
use RedisException;

class Redis implements CoreNoSql
{
    private $redis;
    private $redisConfig;
    public function __construct()
    {
        $this->redisConfig = Config::getConfig('redis')['redis'];
        $this->redis = new \Redis();
        $this->connect();
    }

    /**
     * 获取 Redis 实例
     *
     * @return Redis
     */
    public function getInstance()
    {
        return $this->redis;
    }

    /**
     * 实现 CoreNoSql 接口的方法
     */
    public function connect()
    {
        try {
            $this->redis->connect($this->redisConfig['host'], $this->redisConfig['port']);
            if ($this->redisConfig['password'] !== null) {
                $this->redis->auth($this->redisConfig['password']);
            }
        } catch (RedisException $e) {
            Message::ResponseMessage(601,[],$e->getMessage());
        }
    }



}
