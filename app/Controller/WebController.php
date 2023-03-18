<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/5
 * Time:  0:02
 */

namespace app\Controller;

class WebController
{
    public function index()
    {
//        echo "web";
        $arr = [
            'code'=>200,
            'msg'=>'success',
            'data'=>[]
        ];
        echo json_encode( $arr);
    }
}