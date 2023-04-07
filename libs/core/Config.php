<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/14
 * Time:  21:28
 */

namespace libs\core;

class Config
{
    private static $instance = null;
    private function __construct()
    {
    }
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new static();
        }
        return self::$instance;
    }
    public static function getConfig($key = '')
    {
        $keyArray = explode('.',$key);
        global $_CONFIG;
        $config = $_CONFIG;
        foreach ($keyArray as $item) {
            $config = $config[$item] ?? '';
        }
        return $config;
    }
}