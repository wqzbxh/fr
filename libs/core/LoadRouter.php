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
        $isRouterRead = true;
//        查看文件夹中是否有该文件，并且存在值，直接读出缓存
        if (file_exists($cacheRouterFileConfig)) {
            $configRouter = json_decode(file_get_contents($cacheRouterFileConfig), true);

            if (empty($configRouter)) $isRouterRead = false;
        }
//        遍历route文件夹，并且将数据写入缓存文件
        if ($isRouterRead == false) {

            $files = glob('./route/*.php');
            $configRouter = [];
            foreach ($files as $item) {
                require_once($item);
            }
            file_put_contents($cacheRouterFileConfig, json_encode(Router::$router));
            //中间件缓存到config中
            file_put_contents($cacheRouterFileConfig,json_encode(Router::$middleware),FILE_APPEND);

            return  Router::$router;
        }

        return $configRouter;
    }
}