<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/25
 * Time: 19:05
 */

namespace libs\core;

class Message
{
    /**
     *
     */
     const Messages = [

         200 => 'Success!',
         404 => '未定义的页面!',
//        1、开头系统错误
        100001 => '验证规则定义错误',
        100002 => '规则定义不合法（默认被覆盖）',
        100003 => '错误信息提示（默认被覆盖）',
        200001 => '未找到查询结果',
    ];

    /**
     * @param $code
     * @return array
     */
    public static function ResponseMessage(int $code,array $data = [],$msg = false )
    {
        $returnMessage = self::Messages[$code];
        if($msg) $returnMessage = $msg ;
        return array('code'=>$code,'msg'=> $returnMessage,'data'=>$data);
    }
}