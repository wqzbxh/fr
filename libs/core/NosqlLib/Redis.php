<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/6
 * Time:  15:32
 */

namespace libs\core\NosqlLib;
use libs\core\Config;

class Redis implements  CoreNoSql
{
    //端口
    private $port;
    //host
    private $host;

    private $password;

    private $db = 0;

    public  $redisdb;

    /*
     * 实例化是初始化文件
     * 可链接多个服务器的redis库（需要直接实例化此类才可以，走工厂模式默认是本地的redis）
     */

    public function __construct($host =  null,$port = null  ,$password = null)
    {
        $redisConfig = Config::getConfig('redis')['redis'];
        $this->port = $redisConfig['port'];
        $this->password = $redisConfig['password'];
        $this->host = $redisConfig['host'];
        $this->db = $redisConfig['db'];
        $this->connect();
    }

    /**
     * @return mixed|\Redis
     * 实例化就进行链接
     */
    public function connect()
    {
        // TODO: Implement connect() method.
        $this->redisdb= new \Redis();
        $this->redisdb->connect($this->host,$this->port);
        $this->redisdb->auth($this->password);

    }

    /**
     * @return mixed
     * 获取nosql实例
     */
    public function getInstance()
    {
        return  $this->redisdb;
    }
}