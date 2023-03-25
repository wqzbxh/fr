<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/25
 * Time: 10:32
 */

namespace libs\core;

use libs\core\http\HttpRequest;

class Request
{
    private $method;

    private $allParam;

    private $header;

    public function __construct(...$data)
    {
        $this->header =  HttpRequest::getAllHeaders();
        $this->method = $this->header['method'];
        if(!isset($this->header['content-type'])) $this->header['content-type'] = null;
        $this->allParam = HttpRequest::getRequestParam($this->header['content-type'],$this->method);
    }

    public function method()
    {
        return $this->method;
    }

    public function all()
    {
        return $this->allParam;
    }
    public function get($key,$default = null, $filter = null)
    {
        if(isset($this->allParam[$key])){
            $value = $this->allParam[$key];
        }else{
            if($default !== null){
                $value = $default;
            }else{
                $value = false;
            }
        }
       if($filter !== null){
           $value = $filter($value);
       }
       return $value;
    }

    /**
     * 获取 header 信息
     * @param $key 指定值
     * @param $default 默认值
     * @param $filter
     * @return false|mixed
     */
    public function getHerder($key,$default = null,$filter = null)
    {
        if(isset($this->header[$key])) {
            $value = $this->header[$key];
        }else{
            if($default != null){
                $value = $default;
            }else{
                $value = false;
            }
        }
        if($filter !== null){
            $value = $filter($value);
        }
        return $value;

    }
}
