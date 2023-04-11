<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/6
 * Time:  15:20
 */

namespace libs\core\NosqlLib;

interface CoreNoSql
{

    /**
     * redis\mongodb…………
     * @return mixed
     * 链接数据库
     */
    public  function  connect();

    /**
     * 返回实例
     */
    public function getInstance();

}