<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/7
 * Time:  14:14
 * 所有的nosql 必须在当前目录下统一管理 :libs\core\NosqlLib
 * 简单工厂模式
 */

namespace libs\core\NosqlLib;

class NosqlFactory
{
    public static function factory($className)
    {
        $className = 'libs\core\NosqlLib\\'.$className;
        $instanceNosql = new  $className;
        return $instanceNosql->getInstance();
    }
}