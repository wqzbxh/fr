<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  21:25
 */

namespace libs\core;

class Router
{
    static $router;
//    定义前缀
    static $prefix = '';

    /**
     * @param $url
     * 定义路径
     * @param $controllerAction
     * 定义操作动作
     * @return void
     */
    public static function add($url,$controllerAction)
    {
        self::$router[self::$prefix.$url] = $controllerAction;
    }

    public static function get($url,$controllerAction){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            self::$router[self::$prefix.$url] = $controllerAction;
        }else{
            echo "<h1>您需要做正确的交通工具才能启动</h1>";
            exit;
        }

    }

    /**
     * @param $prefix
     * 定义前缀
     * @param $callback
     * 回调闭包函数
     * @return void
     */
    public static function group($prefix,$callback)
    {
        self::$prefix = $prefix;
        $callback();
        self::$prefix = '';
    }
}