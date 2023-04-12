<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/26
 * Time: 23:07
 */

namespace libs\core\Middleware;

use libs\App;

abstract class Middleware
{
    protected $class;
    protected $class_name;
    protected $method;

    abstract function  handle();
    public function __construct($class,$class_name,$method)
    {
        $this->class = $class;
        $this->method = $method;
        $this->class_name = $class_name;
    }

    protected function next()
    {
        return App::exec($this->class_name,$this->method);
    }
}