<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/17
 * Time:  10:02
 */

namespace libs\core;


use libs\db\Db;

/**
 * 模型抽象类
 */
abstract  class CoreModel
{
    protected  $DB;

    public function __construct()
    {
         $this->DB = Db::connect_database();
    }

}