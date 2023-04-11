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
})->middleware(\app\Middleware\UserMiddleware::class);
