<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/6
 * Time:  22:08
 */

namespace app\Controller\common;

class RandUnit
{
    /**
     * 获取Token
     * @param $length
     * @return string
     * @throws \Exception
     */
    function generateToken($length = 32) {
        return bin2hex(random_bytes($length));
    }
}