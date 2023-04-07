<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/6
 * Time:  15:32
 */

namespace app\Extend;
use libs\core\Config;
use libs\core\Redis\CoreNoSql;

class Redis implements  CoreNoSql
{
    //端口
    private $port;
    //host
    private $host;

    private $password;

    private $db = 0;


    public  $redis_instance;

    /*
     * 实例化是初始化文件
     * 可链接多个服务器的redis库
     */

    public function __construct($host =  null,$port = null  ,$password = null)
    {
        if($host == false && $port == false && $password == false){
            $redisConfig = Config::getConfig('redis')['redis'];
            $this->port = $redisConfig['port'];
            $this->password = $redisConfig['password'];
            $this->host = $redisConfig['host'];
            $this->db = $redisConfig['db'];
        }else{
            $this->port = $port;
            $this->host = $host;
            $this->password = $password;
            $this->db = $password;
        }
        $this->connect();
    }

    /**
     * @return mixed|\Redis
     * 实例化就进行链接
     */
    public function connect()
    {
        // TODO: Implement connect() method.
        $this->redis_instance =   new \Redis();
        $this->redis_instance->connect($this->host,$this->port);
        $this->redis_instance->auth($this->password);
    }

    public function getInstance()
    {
        return $this->redis_instance;
    }
    /**
     * @param string $key
     * @param string $value
     * @param int $expire
     */
    public function set($key, $value, $expire=0){
        // TODO: Implement connect() method.
        if($expire == 0){
            $ret = $this->redis_instance->set($key, $value);
        }else{
            $ret = $this->redis_instance->set($key, $value,$expire);
        }

        return $ret;
    }
}