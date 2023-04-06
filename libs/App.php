<?php
namespace libs;

use libs\core\Message;
use libs\core\LoadConfig;
use libs\core\LoadRouter;
use libs\core\Router;

class App{
    /**
     * @return void
     * 启动函数
     */
    public static function run(){
        self::loadConfig();
        self::runAction();
    }

    /**
     * @return void
     * $_CONFIG
     * config配置全局变量
     * $_CONFIG_ROUTE
     * 路由配置全局变量
     */
    public static function loadConfig()
    {
        global $_CONFIG;
        global $_CONFIG_ROUTE;
        $_CONFIG_ROUTE = LoadRouter::load();
        $_CONFIG = LoadConfig::load();
    }
    /**
     * @return void
     * 根据路由实例化对象
     */
    public static function runAction()
    {
      $path_arr = Path::init();
      $middleware = Router::$middleware;
      $class_name = $path_arr['class_name'];
      $method = $path_arr['action'];
      try{
          if(isset($middleware[$path_arr['url']])){
              $class = new $class_name();
              $middleware = $middleware[$path_arr['url']];
              $middlewareClass = new $middleware($class,$class_name,$method);
              if(is_subclass_of($middlewareClass,'\libs\core\Middleware\Middleware')){
                  $result =   $middlewareClass->handle();
                  if(is_array($result)){
                      echo json_encode($result,true);
                  }
              }else{
                  return Message::ResponseMessage(10004);
              }
              return;
          }

          $method = $path_arr['action'];
          if(method_exists($class_name, $path_arr['action'])){
              $class = new $class_name();
              $result = self::exec($class,$class_name,$method);
              if(is_array($result)){
                  echo json_encode($result,true);
              }
          }else{
              echo "<h1>class not found exception</h1>";
          };
      }catch (\Throwable $e){
            echo $e->getMessage();
      }

    }
    public static function exec($class,$classname,$method)
    {
        global $_CONFIG;
//        前切
        $res = $class->$method();
        $aopAfter = $classname;
        if(in_array($aopAfter,  $_CONFIG['aop'])){
            $aopClassName = $_CONFIG['aop'][$aopAfter];
            $aopClass = new $aopClassName($res);
            $aopClass->exec();
        }else{
//            echo "此次访问不进行日志记载";
        }
        return $res;
    }
}
