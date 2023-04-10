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
        //注册路由
        $_CONFIG_ROUTE = LoadRouter::load();
        //加载配置
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
//        前切可以卸载此处
        $res = $class->$method();
        $aopAfter = $classname;

//        判断当前的实例化的地址存在aop配置文件中是否存在，存在则进行aop的对应类实例化执行该系列操作
        if(array_key_exists($aopAfter,$_CONFIG['aop']) || array_key_exists($aopAfter.'\\'.$method,$_CONFIG['aop'])){
            if(array_key_exists($aopAfter,$_CONFIG['aop'])) $aopClassName = $_CONFIG['aop'][$aopAfter];
//        如果指定了具体要进行切片的方法,默认去加载具体方法的切片配置
            if(array_key_exists($aopAfter.'\\'.$method,$_CONFIG['aop'])) $aopClassName = $_CONFIG['aop'][$aopAfter.'\\'.$method];
            $aopClass = new $aopClassName($res);
            $aopClass->exec();
        }else{
//            echo "此次访问不进行日志记载";
        }
        return $res;
    }
}
