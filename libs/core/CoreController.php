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
    /**
     * 框架默使用Smarty模板
     * @var \Smarty
     */
    protected  $template;
    protected $request;

    public function __construct()
    {
        $this->template = new \Smarty();
        $this->request = new Request();
    }
}
