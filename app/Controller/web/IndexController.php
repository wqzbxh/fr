<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/4
 * Time:  23:54
 */

namespace app\Controller\web;

use libs\core\CoreController;
use libs\db\Db;

class IndexController extends CoreController
{
    public function index(){
        $this->template->assign("name", "Fred Irving Johnathan Bradley Peppergill", true);
        $this->template->display('./app/View/web/index/index.tpl');
    }

    public function index2()
    {
        $db = Db::connect_database()->db;

        $where[] = ['userId','=',33] ;
        $data = [
            'typName' => 'test',
            "description" => 'testdescription'
        ];
        $result = Db::connect_database()->table('user')->where('userId','>',30)->limit(1,3)->count();
        $result = Db::connect_database()->table('unittyp')->insert($data);
//        $result = Db::connect_database()->table('user')->alias('nb')->where($where)->get();
//        $result = Db::connect_database()->table('userpermiasionselection')
//            ->leftjoin('user','user.userId = userpermiasionselection.user_id')
//            ->leftjoin('permission','permission.id = userpermiasionselection.permission_id')
//            ->select();
//        $stm = $db->query('select * from user');
//        $result = $stm->fetchAll();
        var_dump($result);
    }
}