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


    public function test($data = null)
    {
//        $where = [
//            ['type','=','1 or 1 =1']
//        ];
//        $restult = $this->DB->table($this->tablename)->where($where)->count();
        $restult = $this->DB->table($this->tablename)->insertMultiple($data);
        var_dump($restult);exit;
//        return $a;
    }
}