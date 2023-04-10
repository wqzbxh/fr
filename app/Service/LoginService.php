<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/10
 * Time:  13:24
 */

namespace app\Service;

use app\Controller\common\Ldap;
use app\Controller\common\RandUnit;
use app\Controller\common\RedisCache;
use app\Model\UserModel;
use app\Validate\UserValidate;
use libs\core\Message;

class LoginService
{
    public function ladpUserLogin(array $data)
    {
        $userModel = new UserModel();
        $UserValidate = new UserValidate();
        $result = $UserValidate->setScene('unneedage')->validate($data);
        if($result !==  true) return $result;
        $password = $data['password'];
        $cn = $data['username'];
        $LdapService = new Ldap();
        $resultLdap = $LdapService->getLdapUserinfo($cn,$password);
        if($resultLdap){
            $ldap_uid = $resultLdap[0]['uid'][0];
            $where[] = array('ldap_uid','=',$ldap_uid);
            $result = $userModel->getUserModel($where);
            if ($result === false){
                return Message::ResponseMessage(300001,[],'');
            }
            $randUnit = new RandUnit();
            $token = $randUnit->generateToken(32);
            $result['token']=$token;
            $redis = new RedisCache();
            $redis->setTTUserInfo($token,$result);
            return Message::ResponseMessage(200,$result,'');
        }else{
            return Message::ResponseMessage(300002,[],'');
        }
    }

    public function userLogin(array $data)
    {
        $userModel = new UserModel();
        $UserValidate = new UserValidate();
        $result = $UserValidate->setScene('unneedage')->validate($data);
        if($result !==  true) return $result;
        $where[] = array('username','=',$data['username']);
        $where[] = array('password','=',$data['password']);
        $result = $userModel->getUserModel($where);
        if(!$result) return Message::ResponseMessage(200001);     //登录设置token
        $randUnit = new RandUnit();
        $token = $randUnit->generateToken(32);
        $result['token']=$token;
        $redis = new RedisCache();
        $redis->setTTUserInfo($token,$result);
        return Message::ResponseMessage(200,$result);
    }

}