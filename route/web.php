<?php
/**
 * Created by : phpstorm
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  21:26
 */

use libs\core\Router;

Router::add('getParam','web/user/getParam');
Router::add('web/user/create','web/user/create')->middleware(\app\Middleware\UserMiddleware::class);


Router::group('admin_',function (){
    Router::add('user/index','web/user/index');
    Router::add('log','web/user/logRecord');
})->middleware(\app\Middleware\UserMiddleware::class);
