<?php
namespace libs;

use libs\core\LoadConfig;
use libs\core\LoadRouter;

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
      $class_name = $path_arr['class_name'];
      try{
          if(method_exists($class_name, $path_arr['action'])){
              $class = new $class_name();
              $method = $path_arr['action'];
              if(method_exists($class,$method))
              {
                  $result = $class->$method();
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
}
