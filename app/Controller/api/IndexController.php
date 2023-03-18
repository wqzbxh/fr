<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/4
 * Time:  23:08
 */

namespace app\Controller\api;

class IndexController
{
    public function index()
    {
        $returnArray = [
            'code' => 200,
            'msg' => 'success!',
            'data' => []
        ];
        return $returnArray;
    }
}