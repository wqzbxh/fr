<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/25
 * Time: 14:41
 */

namespace libs\core\http;

class HttpRequest
{
    public static function getAllHeaders()
    {

        foreach ($_SERVER as $key => $value){
//            nginx中的响应头和apache有些地方是有些去别的，比如：HTTP_CONTENT_TYPE nginx中带有HTTP但是 apache则不带PHP 需要做兼容
            if(substr($key,0,5) == 'HTTP_'){
                $headers[str_replace(' ','-',strtolower(str_replace('_',' ',substr($key,5))))] = $value;
            }
        }
        if(array_key_exists('content-type',$headers) == false) $headers['content-type'] = $_SERVER['CONTENT_TYPE'];
        $headers['method'] = $_SERVER['REQUEST_METHOD'];

        return $headers;
    }

    public static function getRequestParam($contetType,$method)
    {
        if($contetType == 'application/json'){
            return json_decode(file_get_contents('php://input'),true);
        }

        if($method == 'POST' || $method == 'PUT' || $method == 'GET'  || $method == 'DELETE' ){
            return $_REQUEST;
        }
    }

}