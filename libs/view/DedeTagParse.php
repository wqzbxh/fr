<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/17
 * Time:  9:39
 */

namespace libs\view;

class DedeTagParse
{
    protected $taglist = "if|elseif|else|loop|for|while|=|:=|:e|:html|:";
    protected $string;
    protected $tpldir;
    function __construct($dir, $tpl)
    {
        $this->findReg = "/\\{[ ]*($this->findReg)(\\s*[\\{\\}]+\\s*)?\\}/i";
        $this->tpldir = $dir;
        $this->tpl =$tpl;
    }
}