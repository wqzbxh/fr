<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/24
 * Time: 22:33
 */


namespace app\Controller\common;

use libs\core\Aop\Aop;

class Log extends Aop
{
    public function exec()
    {
        // TODO: Implement exec() method.
        echo "<h1>切片模式记录(具体的控制器前切片)操作日志，返回信息为</h1>";
        var_dump($this->data);
    }

    public static function actionAop()
    {
        echo "<h1>切片模式记录(具体的方法前切片)操作日志，返回信息为</h1>";
    }
}