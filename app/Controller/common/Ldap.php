<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/10
 * Time:  11:34
 */

namespace app\Controller\common;

use libs\core\Config;

class Ldap
{
    private  $domain ;

    private  $base ;

    public function __construct($host =  null,$port = null  ,$password = null)
    {
        $ldapConfig = Config::getConfig('ldap');
        $this->domain = $ldapConfig['domain'];
        $this->base = $ldapConfig['base'];
    }

    /*
     * 根据cn和密码进行查询
     */
    public function getLdapUserinfo($cn,$password)
    {
        //链接
        $ldapconn = ldap_connect($this->domain);
        //密码为sha256加密 (无盐)
        $hashed_password = base64_encode(hash('sha256', $password, true));
        //拼接过滤条件
        $filter = "(&(objectClass=person)(cn=$cn)(userPassword={SHA256}$hashed_password))";
        //搜索
        $search_results = ldap_search($ldapconn,   $this->base, $filter);
        //获取搜索结果
        $entries = ldap_get_entries($ldapconn, $search_results);
        //断开LDAP连接
        ldap_unbind($ldapconn);
        if ($entries['count'] > 0) {
            //用户名和密码匹配
               return $entries;
        } else {
            //用户名和密码不匹配
             return  false;
        }
    }
}