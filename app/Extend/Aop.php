<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/24
 * Time: 22:32
 */

namespace app\Extend;

abstract class Aop
{
    protected $data;

    public function __construct(...$data)
    {
        $this->data = $data;
    }

    abstract function exec();
}