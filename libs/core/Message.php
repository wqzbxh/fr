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
         //        1、开头系统错误
         200 => 'Success!',
         400 => 'Failed to call object, please check for errors',
         404 => 'Undefined page',
         421 => 'An exception occurred during the execution of invokeArgs',
         422 => 'Undefined method name or class name',
         423 => 'There is a problem with middleware inheritance',
         604 => 'redis Anomalous portal venous connection',

        100001 => 'Validation rule definition error',
        100002 => 'Rule definition invalid (overridden by default)',
        100003 => 'Error message prompt (overwritten by default)',
        200001 => 'No corresponding information can be found ',
        300001 => 'This LADP user is not bound to the system! Please contact the administrator!',
        300002 => 'The LDAP user does not exist!'
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