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
//        $requset  =  new Request();
//
//        $token = $requset ->getHerder('token');
//        $decoded = JWT::decode($token, Config::getConfig('app')['jwt_secret_key'], 'HS256');
//        $decoded['ep'] = time()+7200;
//        $jwt = JWT::encode($decoded, 'wqzbxh', 'HS256');
//        $newdecoded = JWT::decode($jwt, Config::getConfig('app')['jwt_secret_key'], 'HS256');
//        $signArray = explode('.',$jwt);
//        $sign = array_pop($signArray);
//        var_dump($token);exit;
//        $result['username'] = $decoded['username'];
//        $result['email'] = $decoded['email'];
//        $redis = new RedisCache();
//        $redis->setTTUserInfo($sign,$result);
//        var_dump($redis);
//        header("Authorization: Bearer " . $jwt);
    }

//    public static function actionAop()
//    {
//        echo "<h1>切片模式记录(具体的方法前切片)操作日志，返回信息为</h1>";
//
//    }
}