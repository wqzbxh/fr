<?php
namespace libs;
use libs\core\Router;

class Path
{

    /**
     * @return array|null
     * 定义是否走强制路由
     * is_forced_router参数据决定(config>app>is_forced_router)
     */
    public static function init()
    {
        global $_CONFIG;
        if(!empty($_CONFIG['app']['is_forced_router']) &&  $_CONFIG['app']['is_forced_router'] == true){
            return self::getForceRouter();
        }else{
            return self::getFreeRouter();
        }
    }

    /**
     * @return array|void
     * 强制路由
     */
    public static function  getForceRouter()
    {

        global $_CONFIG_ROUTE;
        $routes = $_CONFIG_ROUTE;
        if(!empty($routes[substr($_SERVER['REQUEST_URI'],1)])){
            $path =$routes[substr($_SERVER['REQUEST_URI'],1)];
            if($path == '/') $path = 'web/index/index';
            $path_arr = explode('/',$path);
//            $class_arr = explode("/",$path_arr[0]);
            $count = count($path_arr);

            $class_name = '\\app\\'."Controller".'\\';
            for($i=0;$i<$count-1;$i++){
                if($i == $count-2){
//              $class_name .= $class_arr[$i];
                    $class_name .= ucfirst($path_arr[$i]).'Controller';
                }else{
                    $class_name .=$path_arr[$i].'\\';
                }
            }
            return[
                'class_name'=>$class_name,
                'action'=>array_pop($path_arr) ?? 'index'
            ];
        }else{
            echo '错误的路由';
            exit;
        };

    }

    /**
     * @return array|void
     * 我的自由是相对自由,不是绝对自由,别以为你想干啥就干啥,我有我的规矩,路由必须是xx/xx/xx,懂吗?不懂就给你XXX
     */
    public static function getFreeRouter()
    {

        if(!empty($_SERVER['REQUEST_URI'])){

            $path = $_SERVER['REQUEST_URI'];
            if($path == '/') {
                $path = 'web/index/index';
            }else{
                $path =substr($path,1);
            }

            $path_arr = explode('/',$path);
            $class_arr = explode("/",$path_arr[0]);
            $count = count($path_arr);
            if($count<3){
                echo "XXX";exit;
            }
            $class_name = '\\app\\'."Controller".'\\';
            for($i=0;$i<$count-1;$i++){
                if($i == $count-2){
                    $class_name .= ucfirst($path_arr[$i]).'Controller';
                }else{
                    $class_name .=$path_arr[$i].'\\';
                }
            }
            return[
                'class_name'=>$class_name,
                'action'=>array_pop($path_arr) ?? 'index'
            ];
        }else{

            echo '错误的路由';
            exit;
        };
    }

}

