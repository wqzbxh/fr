<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/4/2
 * Time: 1:33
 */

namespace app\Controller\admin;

use app\Controller\common\RandUnit;
use app\Controller\common\RedisCache;
use app\Model\UserModel;
use app\Service\LoginService;
use app\Validate\UserValidate;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use libs\core\CoreController;
use libs\core\Message;
use libs\core\Request;

class LoginController extends CoreController
{

//    public function __construct(RedisCache $redisCache)
//    {
//        var_dump($redisCache->getRedisInstance()->set('aa','aa'));
//    }

    /**
     * @return array|bool|true
     */
    public function login()
    {
        $data = $this->request->all();
        $loginService = new LoginService();
        if($data['login_ldap'] === true){
            $result = $loginService->ladpUserLogin($data);
        }else{
            $result =  $loginService->userLogin($data);
        }
        return $result;
    }

    /**
     * 登出
     * @return void
     */
    public function logout()
    {
        //清除redis缓存
        $token = $this->request->getHerder('token');
        $redis = new RedisCache();
        $result = $redis->del($token);
        var_dump($result);
        return Message::ResponseMessage(200,[],'');
    }
    /** 登出
     * 测试接口
     */
    public function reateTimesheet(Request $request)
    {
//        var_dump($request->all());exit;


        $token = $this->request->getHerder('token');
        $decoded = JWT::decode($token, new Key('wqzbxh', 'HS256'));
        $decoded = get_object_vars($decoded);
        $decoded['ep'] = time()+7200;
        $jwt = JWT::encode($decoded, 'wqzbxh', 'HS256');
        $signArray = explode('.',$jwt);

        $sign = array_pop($signArray);
        $result['token']=$jwt;
        //删除原来的redis中的key
        $redis = new RedisCache();
        $redis->setTTUserInfo($sign,$result);
        $this->token = $jwt;
        header("Authorization: Bearer " . $this->token);
        return Message::ResponseMessage(200,[],'');
//        $model = new UserModel();
//
//        $model->test();
//        $data['name'] = $this->request->get('name');
//        var_dump($data,$token);

    }

}