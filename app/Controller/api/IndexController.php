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
use app\ExtraExpand\server\EmailSender;
use app\Model\UserModel;
use libs\core\Cache\Cache;
use libs\core\CoreController;
use libs\core\Curl\Curl;
use libs\core\Message;
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
        $data = array(array(
            'name'=>'shenguan',
            'age' => 1,
        ));


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
//         $this->testMail();

    }

    /**
     * @return void
     * 支持多个附件 ，发送多人等操作
     */
    public function testMail()
    {
        $transport = Transport::fromDsn('smtp://smtp.qq.com:465');
        $transport->setUsername('179939480@qq.com');
        $transport->setPassword('anjawckjdcwdbhai');

        $emailSender = new EmailSender($transport, '179939480@qq.com','哑巴湖大水怪');

        $subject = '邮件';
        $textBody = 'Sending emails is fun again!';
        $htmlBody = '<p>See Twig integration for better HTML integration!</p>';
        $attachments = [
            ['path' => './public/image/logo.jpg', 'filename' => 'logo.jpg'],
            ['path' => './a.text', 'filename' => 'a.text']
        ];
        $toRecipients = [new Address('wqzbxh@163.com', 'Haiyang Recipient')];
//        $ccRecipients = [new Address('cc-recipient@example.com', 'CC Recipient')];
//        $bccRecipients = [new Address('bcc-recipient@example.com', 'BCC Recipient')];

        $emailSender->sendEmail($subject, $textBody, $htmlBody, $attachments, $toRecipients);
    }

    /**
     * @return void
     *
     */
    public function jwt(Request $request)
    {
        var_dump($request->all());
    }
}