<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/10
 * Time:  16:09
 */

namespace app\Controller\common;

use libs\core\Aop\Aop;

class RefreshRedisToken extends Aop
{

    public function exec()
    {
        // TODO: Implement exec() method.
        //例如每次用户操作结束后更新redis的时间
        echo '//////';
        var_dump($this->data);
        echo "<h1>更新redis</h1>";
    }

//    public static function actionAop()
//    {
//        echo "<h1>切片模式记录(具体的方法前切片)操作日志，返回信息为</h1>";
//
//    }
}