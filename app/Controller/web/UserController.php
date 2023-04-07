<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/17
 * Time:  10:05
 */

namespace app\Controller\web;
use app\Model\UserModel;
use app\Validate\UserValidate;
use libs\core\CoreController;

class UserController extends CoreController
{
    public function index()
    {
        $userModel = new UserModel();
        $a = $userModel->test();
        $this->template->assign("name", $a, true);
        $this->template->assign("title", 'WHY', true);
        $this->template->display('./app/View/web/index/index.tpl');

    }

    public function logRecord()
    {
        echo '1;';
    }

    /**
     * @return void
     *
     */
    public function getParam()
    {
        var_dump($this->request->get('s','默认值','trim'));
        var_dump($this->request->all());
    }
    /**
     *
     */
    public function create()
    {
        $data = $this->request->all();
        $UserValidate = new UserValidate();
        $result = $UserValidate->setScene('unneedage')->validate($data);
        return $result;
    }
}