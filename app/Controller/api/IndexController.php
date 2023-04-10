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
use libs\core\Cache\Cache;

class IndexController
{
    public function index()
    {
//        Redis测试
//       $redisTest =  new  RedisCache();
//       $redisTest->getRedisInstance();
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
        //连接LDAP服务器
        $password = 'admin';
        $cn = 'cheng';
        $LdapService = new Ldap();
        $result = $LdapService->getLdapUserinfo($cn,$password);
        var_dump($result);
    }
}