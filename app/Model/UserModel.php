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
    public function test()
    {
//        var_dump(self::$DB);
        $a = self::$DB->query('select * from user ');
        return $a;

    }
}