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

class IndexController extends CoreController
{
    public function index()
    {
//        Redis测试

        var_dump(Date('Y-m-d'));
       $redisTest =  new  RedisCache();
      $redis = $redisTest->getRedisInstance();
      $redis->hSet('user','name','aaaa');
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
//        批量插入
        $data = [
            ['username'=>'AAAAAA','password'=>'aaaaaa','type'=>2],
            ['username'=>'BBBBBB','password'=>'aaaaaa','type'=>2],
            ['username'=>'xiaohei','password'=>'aaaaaa','type'=>2],
            ['username'=>'xiaobai','password'=>'aaaaaa','type'=>2],
        ];
        $usermode = new UserModel();
        $usermode->test($data);
    }
}