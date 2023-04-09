<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/17
 * Time:  10:02
 */

namespace app\Model;

use libs\core\CoreModel;

class UserModel extends CoreModel
{
    protected $tablename = 'user';
    public function getUserModel($data)
    {
       $result = $this->DB->table($this->tablename)->filed('id,username,phone,email,id')->where($data)->get();
       return $result;
//        return $a;
    }
}