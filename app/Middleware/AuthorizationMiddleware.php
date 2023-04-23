<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/4/23
 * Time: 22:58
 */

namespace app\Middleware;
use app\Controller\common\RedisCache;
use libs\core\Config;
use libs\core\Jwt\JWT;
use libs\core\Middleware\Middleware;
use libs\core\Request;

class AuthorizationMiddleware extends Middleware
{
    protected $token;
    public function handle()
    {
        $request = new Request();
        $this->token  = $request->getHerder('token');
//        检验token是否正确
        $this->verificationToken();
//        权限校验……
        return $this->next();
    }

    /**
     * 检查token
     */
    protected function verificationToken()
    {
        if ( $this->token ) {
            $jwtInfo = JWT::decode($this->token, Config::getConfig('app')['jwt_secret_key']);
            if ($jwtInfo !== false)
            {
                if($jwtInfo['ep'] >time()){
//                    更新token 并且设置发送响应头
//                     在这更新token则视为jwt永不会过期,权衡业务利弊,
//                    在切面模式下,可设置每次更新token
                }else{
                    echo '登录过期';
                };
            }else{
                echo '数据校验失败';
            }
        }else{
            return '参数丢失token';
        }


    }
}