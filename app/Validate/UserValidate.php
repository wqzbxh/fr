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
        'age' => ['require'],
    ];
    protected $message =[
        'username.require' => 'Name must exist',
        'password.require' => 'Password must exist',
        'username.maxLen:16' => 'The maximum value is 8',
        'username.minLen:4' => 'Minimum length no more than 4',
    ];
    protected $scene = [
//        'needage' => ['name','age','password'],
        'unneedage' => ['username','password'],
    ];
}