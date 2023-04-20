<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/4
 * Time:  23:08
 */

namespace app\Controller\api;

use app\Controller\common\Ldap;
use app\Controller\common\RedisCache;
use app\Model\UserModel;
use libs\core\Cache\Cache;
use libs\core\CoreController;
use libs\core\Curl\Curl;
use libs\core\Request;

class IndexController extends CoreController
{
    public function index(Request $request)
    {
        $curl = new Curl('https://ip.useragentinfo.com/json?ip=116.179.37.4');

        $response = $curl->get('');
        var_dump($response);
//      var_dump($request->all());
//       $redisTest =  new  RedisCache();
//      $redis = $redisTest->getRedisInstance();
//        $redis->hSet('user','name','aaaa');
//        $redis->hSet('sss','name','aaaa');
//
//         $redis->del('user');
//        Redis测试
//        批量插入
//        $data = [
//            ['username'=>'AAAAAA','password'=>'aaaaaa','type'=>2],
//            ['username'=>'BBBBBB','password'=>'aaaaaa','type'=>2],
//            ['username'=>'xiaohei','password'=>'aaaaaa','type'=>2],
//            ['username'=>'xiaobai','password'=>'aaaaaa','type'=>2],
//        ];
//        $usermode = new UserModel();
//        $usermode->test($data);
//        var_dump(Date('Y-m-d'));
//       $redisTest =  new  RedisCache();
//      $redis = $redisTest->getRedisInstance();
//      $redis->hSet('user','name','aaaa');
//        缓存文件测试 新增文件缓存类Cache
//        $data = array(
//            'name'=>'shenguan',
//            'age' => 1,
//        );
//        $cache = new Cache();
//        $cache->set("name", "wanghaiyang");
//        $cache->set("company", $data);
//        var_dump( $cache->get('name'));
//        var_dump( $cache->get('company'));
//        ldapc测试
//        //连接LDAP服务器
//        $password = 'admin';
//        $cn = 'cheng';
//        $LdapService = new Ldap();
//        $result = $LdapService->getLdapUserinfo($cn,$password);
//        var_dump($result);

    }
}