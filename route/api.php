<?php
/**
 * Created by : phpstorm
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  21:26
 */
use libs\core\Router;

Router::add('index','web/index/index');

Router::group('admin_',function (){
    Router::add('update','web/index/index');
});

Router::get('doc','common/Export/exportSql');