<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/10
 * Time:  16:09
 */

namespace app\Controller\common;

use libs\core\Aop\Aop;
use libs\core\Config;
use libs\core\Jwt\JWT;
use libs\core\Request;

class RefreshToken extends Aop
{

    public function exec()
    {
        // TODO: Implement exec() method.
        //例如每次用户操作结束后更新redis的时间

        $requset  =  new Request();
        $token = $requset ->getHerder('token');
        var_dump($token);
        $decoded = JWT::decode($token, Config::getConfig('app')['jwt_secret_key'], 'HS256');
        var_dump($decoded);
        $decoded['ep'] = time()+7200;
        $jwt = JWT::encode($decoded, 'wqzbxh', 'HS256');
        $newdecoded = JWT::decode($jwt, Config::getConfig('app')['jwt_secret_key'], 'HS256');
        var_dump($newdecoded);
        $signArray = explode('.',$jwt);
        $sign = array_pop($signArray);
        $result['username'] = $decoded['username'];
        $result['email'] = $decoded['email'];
        $redis = new RedisCache();
        $redis->setTTUserInfo($sign,$result);
        header("Authorization: Bearer " . $jwt);
        var_dump($jwt);
        echo "<h1>刷新$jwt</h1>";
    }

//    public static function actionAop()
//    {
//        echo "<h1>切片模式记录(具体的方法前切片)操作日志，返回信息为</h1>";
//
//    }
}