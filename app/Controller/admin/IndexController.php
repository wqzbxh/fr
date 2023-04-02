<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/4/2
 * Time: 1:33
 */

namespace app\Controller\admin;

use app\Model\UserModel;
use app\Validate\UserValidate;
use libs\core\CoreController;
use libs\core\Message;

class IndexController extends CoreController
{
    public function login()
    {
        $userModel = new UserModel();
        $UserValidate = new UserValidate();
        $data = $this->request->all();
        $result = $UserValidate->setScene('unneedage')->validate($data);
        if($result !==  true) return $result;
        $where[] = array('username','=',$data['username']);
        $where[] = array('password','=',$data['password']);
        $result = $userModel->getUserModel($where);
        if(!$result) return Message::ResponseMessage(200001);
        return Message::ResponseMessage(200,$result);;
    }
}