<?php
namespace libs;

use libs\core\Error;
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
      $class = new $class_name();
        $method = $path_arr['action'];
        var_dump($path_arr);
        var_dump($middleware);
      try{
          if(isset($middleware[$path_arr['url']])){
              $middleware = $middleware[$path_arr['url']];
              $middlewareClass = new $middleware($class,$class_name,$method);
              if(is_subclass_of($middlewareClass,'\libs\core\Middleware\Middleware')){
                  $result =   $middlewareClass->handle();
                  if(is_array($result)){
                      echo json_encode($result);
                  }
              }else{
                  return Error::ErrorMsg(10004);
              }
          }

          $method = $path_arr['action'];
          if(method_exists($class_name, $path_arr['action'])){
              $class = new $class_name();
              if(method_exists($class,$method))
              {
                  $result = self::exec($class,$class_name,$method);
                  if(is_array($result)){
                      echo json_encode($result);
                  }
              }else{
                  throw new \Exception('Error');
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
        $res = $class->$method();
        $aopAfter = $classname;
        if(!empty($_CONFIG['aop'][$aopAfter])){
            $aopClassName = $_CONFIG['aop'][$aopAfter];
            $aopClass = new $aopClassName;
            $aopClass->exec($res);
        }
        return $res;


    }
}
