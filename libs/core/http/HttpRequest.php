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
            if(substr($key,0,5) == 'HTTP_'){
                $headers[str_replace(' ','-',strtolower(str_replace('_',' ',substr($key,5))))] = $value;
            }
        }
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