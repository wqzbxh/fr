<?php
namespace libs;

use libs\core\Message;
use libs\core\LoadConfig;
use libs\core\LoadRouter;
use libs\core\Reflection;
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
        global $_CONFIG; // 声明全局变量$_CONFIG
        global $_CONFIG_ROUTE; // 声明全局变量$_CONFIG_ROUTE
        // 加载配置
        $_CONFIG = LoadConfig::load(); // 调用LoadConfig::load()函数来加载配置，并将结果赋值给$_CONFIG全局变量
        // 注册路由
        $_CONFIG_ROUTE = LoadRouter::load(); // 调用LoadRouter::load()函数来注册路由，并将结果赋值给$_CONFIG_ROUTE全局变量
    }
    /**
     * @return void
     * 根据路由实例化对象
     */
    public static function runAction()
    {
        // 获取URL的参数信息
      $path_arr = Path::init();
        // 获取路由中间件信息
      $middleware = Router::$middleware;
        // 获取控制器名称
      $class_name = $path_arr['class_name'];
        // 获取控制器方法名
      $method = $path_arr['action'];
      try{
          // 判断是否存在中间件
          if(isset($middleware[$path_arr['url']])){
              // 实例化控制器
              $class = new $class_name();
              // 获取当前中间件名称
              $middleware = $middleware[$path_arr['url']];
              // 实例化中间件
              $middlewareClass = new $middleware($class,$class_name,$method);
              // 判断是否为中间件的子类
              if(is_subclass_of($middlewareClass,'\libs\core\Middleware\Middleware')){
                  // 调用中间件的处理方法
                  $result =   $middlewareClass->handle();
                  // 判断返回值是否为数组，如果是，则将其转换为JSON格式
                  if(is_array($result)){
                      echo json_encode($result,true);
                  }else{
                      echo $result;
                  }
              }else{
                  // 返回错误信息
                  return Message::ResponseMessage(423);
              }
              return;
          }
          // 执行控制器方法
          if(method_exists($class_name, $method)){
              $result = self::exec($class_name,$method);
              // 判断返回值是否为数组，如果是，则将其转换为JSON格式
              if(is_array($result)){
                  echo json_encode($result,true);
              }
          }else{
              // 输出错误信息
              return Message::ResponseMessage(422);
          };
      }catch (\Throwable $e){
            echo $e->getMessage();
      }
    }

    /**
     * 执行
     * @param $classname
     * @param $method
     * @return mixed
     *
     */
    public static function exec($classname,$method)
    {
        global $_CONFIG;
        // 前切可以卸载此处
        //$beforeAopClass->exec();
        // 获取反射类执行结果
        $res = Reflection::exec($classname,$method);
        $aopAfter = $classname;
        // 判断当前类是否存在aop配置，如果存在则进行对应类实例化执行该系列操作
        if(array_key_exists($aopAfter,$_CONFIG['aop']) || array_key_exists($aopAfter.'\\'.$method,$_CONFIG['aop'])){
            // 如果指定了具体要进行切片的方法，默认去加载具体方法的切片配置
            $aopClassName = '';
            if (array_key_exists($aopAfter.'\\'.$method, $_CONFIG['aop'])) {
                $aopClassName = $_CONFIG['aop'][$aopAfter.'\\'.$method];
            } elseif (array_key_exists($aopAfter, $_CONFIG['aop'])) {
                $aopClassName = $_CONFIG['aop'][$aopAfter];
            }
            // 实例化AOP类并执行
            if (!empty($aopClassName)) {
                $aopClass = new $aopClassName($res);
                $aopClass->exec();
            }
        }else{
            // 如果不存在配置，则不记录日志
            // echo "此次访问不进行日志记载";
        }
        return $res;
    }
}
