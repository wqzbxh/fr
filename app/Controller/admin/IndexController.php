<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/4/2
 * Time: 1:33
 */

namespace app\Controller\admin;

use app\Controller\common\RandUnit;
use app\Model\UserModel;
use app\Service\LoginService;
use app\Validate\UserValidate;
use libs\core\CoreController;
use libs\core\Message;

class IndexController extends CoreController
{
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
     * 测试接口
     */
    public function reateTimesheet()
    {
        $data = $this->request->all();
        $token = $this->request->getHerder('token');
        var_dump($data,$token);
    }

}