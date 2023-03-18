<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/17
 * Time:  9:56
 */

namespace libs\core;

class CoreController
{
    protected  $template;
    public function __construct()
    {
        $this->template = new \Smarty();
    }
}