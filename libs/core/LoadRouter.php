<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  22:24
 */

namespace libs\core;

class LoadRouter
{
    /**
     * @return array|mixed
     * 将路由缓存到route文件中
     */
    public static function load()
    {
        $cacheRouterFileConfig = './cache/route';
        $isRouterRead = false;
        global $_CONFIG;
//        查看文件夹中是否有该文件，
        if (file_exists($cacheRouterFileConfig)) {
//          读取缓存文件中的配置文件内容
            $configStr = file_get_contents($cacheRouterFileConfig);
//            判断文件内容是不是为空,为空则去走加载配置
            if(!empty($configStr)){
//                将缓存配置中德路由和中间件分开
                $str_arr = explode('|', $configStr, 2);
//                获取路由配置参数
                $configRouter = json_decode($str_arr[0], true);
//                获取中间件配置参数
                $middleware = json_decode($str_arr[1] , true);
//                如果路由不为空，并且缓存打开则将配置中中间件和路由参数返回出去
                if($configRouter && $_CONFIG['app']['is_route_cache'] === true){
                    Router::$router = $configRouter;
                    Router::$middleware = $middleware;
                    return  Router::$router;
                }

            }
        }
        if ($isRouterRead == false) {
//            遍历文件数组
            $files = glob('./route/*.php');
//          循环载入配置文件
            foreach ($files as $item) {
                require_once($item);
            }
//            写入路由参数进入文件,后面跟上|便于分割操作
            file_put_contents($cacheRouterFileConfig, json_encode(Router::$router).'|');
//            中间件缓存到config中
            file_put_contents($cacheRouterFileConfig,json_encode(Router::$middleware),FILE_APPEND);
        }
//        返回路由
        return  Router::$router;
    }
}