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

    static $currentUrl = '';

    static $groupUrl = [];

    static $isGroup = false;

    static $middleware;

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
        if(self::$isGroup == true){
            self::$groupUrl[] = self::$prefix.$url;
        }else{
            self::$currentUrl = self::$prefix.$url;
        }
        return new self;
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
        self::$currentUrl = '';
        self::$groupUrl = [];
        self::$isGroup = true;
        self::$prefix = $prefix;
        $callback();
        self::$prefix = '';
        self::$isGroup = false;
        return new self;
    }

    /**
     * 中间件
     * @param $name
     * @return void
     */
    public function middleware($name)
    {
        if(self::$currentUrl == ''){
            foreach (self::$groupUrl as $value){
                self::$middleware[$value] = $name ;
            }
        }else{
            self::$middleware[self::$currentUrl] = $name ;
        }
        self::$currentUrl = '';
        self::$groupUrl = [];
    }
}