<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/17
 * Time:  10:02
 */

namespace app\Model;

use libs\core\CoreModel;
use libs\db\Db;

class UserModel extends CoreModel
{
    protected $tablename = 'user';

    public function __construct()
    {
//        重写父类
        $this->DB = Db::connect_database('database2.mysql');
    }

    public function getUserModel($data)
    {
       $result = $this->DB->table($this->tablename)->filed('id,username,phone,email,id')->where($data)->get();
       return $result;
//        return $a;
    }


    public function test($data = null)
    {
        $restult = $this->DB->table($this->tablename)->select();
        var_dump($restult);exit;
//        return $a;
    }
}