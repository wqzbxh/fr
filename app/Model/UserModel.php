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
//    protected $tablename = 'user';
    protected $tablename = 'xcx_user';

//    public function __construct()
//    {
//        重写父类
//        $this->DB = Db::connect_database('database2.mysql');
//    }

    public function getUserModel($data)
    {
       $result = $this->DB->table($this->tablename)->filed('id,username,phone,email,id')->where($data)->get();
       return $result;
//        return $a;
    }


    public function test($start,$length,$search,$order)
    {
        $where = [];
        if($search){
            $where[] = array('name',' regexp ',$search);
            $where[] = array('username',' regexp ',$search);
            $where[] = array('role',' regexp ',$search);
        }
        $data = $this->DB->table($this->tablename)->orWhere($where)->limit(($start-1)*$length,$length)->select();
        $total = $this->DB->table($this->tablename)->orWhere($where)->count();
//        var_dump($total);
        $restult['datalist'] = $data;
        $restult['itemsPerPage'] = (int)$start;
        $restult['totalItems'] = $total;
        return $restult;
    }
}