<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/25
 * Time: 18:54
 */

namespace libs\core\Validate;

use libs\core\Error;

class Validate
{
    protected $scene = [];
    protected $message = [];
    protected $rules = [];
    protected $nowScene = null;

    public function validate($data)
    {
        if($this->nowScene !== null){
            $fileds = $this->scene[$this->nowScene];
        }else{
            $fileds = array_keys($this->rules);
        }
        if(!is_array($fileds)){
            return Error::ErrorMsg(100001);
        }
        foreach ($fileds as $fv){
            //循环具体字段规则 fv为字段 eg：name
            foreach ($this->rules[$fv] as $rule){
                $rulrArr = explode(':',$rule);
                $ruleMethod = $rulrArr[0];
                $ruleMethodValue  = $rulrArr[1] ?? false;
                if(method_exists(ValidateRule::class,$ruleMethod)){
                    $result = ValidateRule::$ruleMethod($data,$fv,$ruleMethodValue);
                }else{
                    if(isset($data[$fv])){
                        $result = $ruleMethod($data[$fv]);
                    }else{
                        continue;
                    }
                }
                if($result){
                    continue;
                }else{
                    $message = Error::ErrorMsg(100002,$fv.'Field is not legal!');
                    $messageRule = $fv.'.'.$rule;
                    if(isset($this->message[$messageRule])){
                        $message = $this->message[$messageRule];
                    }
                    return Error::ErrorMsg(100003,$message);
                }
            }
        }
        return true;
    }

    public function setScene($value)
    {
        $this->nowScene = $value;
        return $this;
    }
}