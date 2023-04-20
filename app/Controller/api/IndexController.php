<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/4
 * Time:  23:08
 */

namespace app\Controller\api;

use app\Controller\common\Ldap;
use app\Controller\common\RedisCache;
use app\Model\UserModel;
use libs\core\Cache\Cache;
use libs\core\CoreController;
use libs\core\Curl\Curl;
use libs\core\Request;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class IndexController extends CoreController
{
    public function index(Request $request)
    {
//        $curl = new Curl('https://ip.useragentinfo.com/json?ip=116.179.37.4');
//
//        $response = $curl->get('');
//        var_dump($response);
//      var_dump($request->all());
//       $redisTest =  new  RedisCache();
//      $redis = $redisTest->getRedisInstance();
//        $redis->hSet('user','name','aaaa');
//        $redis->hSet('sss','name','aaaa');
//
//         $redis->del('user');
//        Redis测试
//        批量插入
//        $data = [
//            ['username'=>'AAAAAA','password'=>'aaaaaa','type'=>2],
//            ['username'=>'BBBBBB','password'=>'aaaaaa','type'=>2],
//            ['username'=>'xiaohei','password'=>'aaaaaa','type'=>2],
//            ['username'=>'xiaobai','password'=>'aaaaaa','type'=>2],
//        ];
//        $usermode = new UserModel();
//        $usermode->test($data);
//        var_dump(Date('Y-m-d'));
//       $redisTest =  new  RedisCache();
//      $redis = $redisTest->getRedisInstance();
//      $redis->hSet('user','name','aaaa');
//        缓存文件测试 新增文件缓存类Cache
//        $data = array(
//            'name'=>'shenguan',
//            'age' => 1,
//        );
//        $cache = new Cache();
//        $cache->set("name", "wanghaiyang");
//        $cache->set("company", $data);
//        var_dump( $cache->get('name'));
//        var_dump( $cache->get('company'));
//        ldapc测试
//        //连接LDAP服务器
//        $password = 'admin';
//        $cn = 'cheng';
//        $LdapService = new Ldap();
//        $result = $LdapService->getLdapUserinfo($cn,$password);
//        var_dump($result);
        return $this->email();

    }

    /**
     * @return null
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     *
     * 将QQ邮箱的SMTP服务器地址为smtp.qq.com:465，
     * QQ邮箱账号
     * 授权码（不是登录密码）进行身份验证。
     */
    public function email()
    {
        $transport = Transport::fromDsn('smtp://smtp.qq.com:465');
        $transport->setUsername('179939480@qq.com');
        $transport->setPassword('anjawckjdcwdbhai');
        $mailer = new Mailer($transport);
        $path = './public/image/logo.jpg';
//        $path = './a.text';
        $email = (new Email())
//            ->from('179939480@qq.com','nihao')//设置发件人的电子邮件地址和名称。第一个参数是发件人的电子邮件地址，第二个参数是可选的发件人名称。
            ->from(new Address('179939480@qq.com', 'Haiyang'))
            ->to(new Address('wqzbxh@163.com', 'Haiyang Recipient'))
            ->to('wqzbxh@163.com')// 设置邮件的收件人地址。
//            ->cc('1332548325@qq.com')// 设置邮件的抄送地址。
//            ->bcc('bcc@example.com')//设置邮件的暗送地址。
//            ->replyTo('fabien@example.com')// 设置邮件的回复地址。
            ->priority(Email::PRIORITY_HIGH)//设置邮件的优先级为高。
            ->subject('Time for Symfony Mailer!')//设置邮件的主题。
            ->text('Sending emails is fun again!')//设置邮件的纯文本内容。
            ->attach(file_get_contents($path),'1.jpg')//添加一个附件。第一个参数是附件的内容，第二个参数是附件的文件名。
            ->html('<p>See Twig integration for better HTML integration!</p>');// 设置邮件的HTML内容。
            return $mailer->send($email);
    }
}