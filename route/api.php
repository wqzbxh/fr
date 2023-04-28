<?php
/**
 * Created by : phpstorm
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  21:26
 */
use libs\core\Router;

Router::group('api_',function (){
    Router::add('index','api/index/index');
    Router::add('y','api/index/goolyzm');
    Router::add('z','api/index/goolyzm2');
    Router::add('m','api/index/goolyzm3');
})->middleware(\app\Middleware\UserMiddleware::class);
