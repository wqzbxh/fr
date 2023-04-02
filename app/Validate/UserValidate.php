<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/25
 * Time: 18:53
 */

namespace app\Validate;

use libs\core\Validate\Validate;

class UserValidate extends Validate
{
    protected $rules = [
        'username' => ['require','maxLen:8','minLen:4'],
        'password' => ['require'],
    ];

    protected $message =[
        'username.require' => '姓名必须存在',
        'password.require' => '密码必须存在',
        'username.maxLen:8' => '最大不超过8',
        'username.minLen:4' => '最小长度不过4',

    ];
    protected $scene = [
//        'needage' => ['name','age','password'],
        'unneedage' => ['username','password'],
    ];
}