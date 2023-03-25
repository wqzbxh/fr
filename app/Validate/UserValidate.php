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
        'age' => ['require','int','maxLen:6','minLen:3'],
        'name' => ['require'],
        'password' => ['require'],
    ];

    protected $message =[
        'name.require' => '姓名必须存在',
        'age.require' => '年龄必须存在',
        'password.require' => '密码必须存在',
        'age.int' => '年龄必须为整数',
        'age.max:3' => '最大不超过3',
        'age.maxLen:6' => '最大长度不过6',
        'age.minLen:3' => '最小长度超过3',
    ];
    protected $scene = [
        'needage' => ['name','age','password'],
        'unneedage' => ['name','password'],
    ];
}