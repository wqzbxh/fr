<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/14
 * Time:  21:38
 */

namespace libs\db;

use libs\core\Config;

class Db
{

    /**
     * @var
     * 定义数据库配置文件变量
     */
    protected static $dbCofig;
    /**
     * @var
     * 定义数据库实例
     */
    private static $db_instance;

    /**
     * @var
     * 定义链式查询表名
     */
    private $table = '';
    /**
     * @var
     * 定义链式查询条件
     */
    private $where = 'where (1 = 1)';
    /**
     * @var
     * 定义链式查询limit
     */
    private $limit = '';
    /**
     * @var
     * 定义链式查询order
     */
    private $order = '';
    /**
     * @var
     * 定义链式查询字段，默认全部
     */
    private $filed = ' * ';
    /**
     * @var
     * 定义链式查询别名
     */
    private $alias = '';
    /**
     * @var
     * 定义链式左连接查询
     */
    private $leftJoin = '';


    /**
     * @return void
     * 单例模式，禁止克隆
     */
    private function __clone()
    {
    }

    /**
     * 构造函数，加载PDO对象
     */
    private function __construct()
    {
        $dsn = "mysql:host=".self::$dbCofig['host'].";dbname=".self::$dbCofig['dbname'].";port=".self::$dbCofig['port'];
        try{
            $this->db = new \PDO($dsn,self::$dbCofig['username'],self::$dbCofig['password']);
            $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die('Database connection failure!' . $e->getMessage());
        }
    }

    /**
     * @param $tablename
     * @return mixed
     * 获取表名
     * 返回实例
     */
    public function table($tablename)
    {
        $this->table = $tablename;
        return self::$db_instance;
    }
    /**
     * @param $tablename
     * @return mixed
     * 获取字段
     * 返回实例
     */
    public function filed($filed)
    {
        $this->filed = $filed;
        return self::$db_instance;
    }
    /**
     * @param $tablename
     * @return mixed
     * 释放资源变量
     */

    /**
     * @return void
     * 获取limit，sql
     */
    public function limit($start,$limit = false)
    {

        $this->limit = 'limit '.$start;
        if($limit != false){
            $this->limit = 'limit '.$start.','.$limit;
        }
        return self::$db_instance;
    }
    private function free()
    {
        $this->filed = '*';
        $this->where = ' where (1 = 1) ';
        $this->table=$this->limit=$this->order=$this->leftJoin='';
    }

    /**
     * @param $where
     * @param $sep
     * @param $value
     * @return mixed
     * 拼装where条件
     * 返回实例
     */
    public function where($where,$sep = '',$value = '')
    {
        if(is_array($where)){
            foreach ($where as $item)
            {
                $this->where .= 'and ';
                foreach ($item as $k => $v)
                {
                    if($k == 2){
                        if(is_string($v)){
                            $v = '"'.$v.'"';
                        }
                    }
                    $this->where.= $v ;
                }
            }
        }else{
            if (is_string($value)){
                $value = '"'.$value.'"';
            }
            $this->where.= ' and '.$where.' '.$sep.' '.$value;
        }
        $this->where = str_replace('(1 = 1) and',' ',$this->where);
        return self::$db_instance;
    }

    public function count()
    {
        $count = 0;
        try {
            $sql = $this->getSql();
            $result = $this->db->query($sql);
            $list = $result->fetchAll();
            $count = count($list);
        }catch (\Throwable $e){
            die('Database connection failure!' . $e->getMessage());
        }
        $this->free();
        return $count;
    }
    /**
     * @param $table
     * @param $condition
     * @return mixed
     * 拼装左连接
     */
    public function leftJoin($table,$condition)
    {
        $this->leftJoin .= ' left join '.$table.' on '.$condition;
        return self::$db_instance;
    }

    /**
     * @param $aliasName
     * @return mixed
     * 别名
     */
    public function alias($aliasName)
    {
        $this->alias = $aliasName;
        return self::$db_instance;
    }

    /**
     * @return array|false|void
     * 查询集合
     */
    public function select()
    {
        $list = [];
        try {
            $sql = $this->getSql();
//            var_dump($sql);exit;
            $result = $this->db->query($sql);
            $list = $result->fetchAll();
        }catch (\Throwable $e){
            die('Database connection failure!' . $e->getMessage());
        }
        $this->free();
        return $list;
    }

    /**
     * @return mixed|void
     * 查询单个记录
     */
    public function get()
    {
        $list = [];
        try {
            $sql = $this->getSql();
            $result = $this->db->query($sql);
            $list = $result->fetch();
        }catch (\Throwable $e){
            die('Database connection failure!' . $e->getMessage());
        }
        $this->free();
        return $list;
    }

    /**
     * @param $sql
     * @return array|false
     * @throws \Exception
     * 原生查询
     */
    public function query($sql)
    {
        $list = [];
        try {
            $result =  $this->db->query($sql);
            $list = $result->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\Throwable $exception){
            throw new \Exception('查询异常,返回信息为:'.$exception->getMessage());
        }
        $this->free();
        return $list;
    }


    /** 
     * @param $sql
     * @return array|false
     * @throws \Exception
     * 原生查询
     */
    public function queryNative(string $sql , array $arrayValue = array() , bool $isset = false)
    {
        $list = [];
        try {
            $stmt = $this->db->prepare($sql);
            //判断是否是带有带有参数的sql语句，
            if(is_array($arrayValue) && count($arrayValue) == count($arrayValue,1) && !empty($arrayValue)){
                $stmt->execute($arrayValue);
            }else{
                $stmt->execute();
            }

            if($isset){
                $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }else{
                $list = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
        }catch (\Throwable $exception){
            throw new \Exception('查询异常,返回信息为:'.$exception->getMessage());
        }
        $this->free();
        return $list;
    }
    /**
     * @return string
     * 拼装sql
     */
    private function getSql()
    {
        $sql = 'select '.$this->filed.' from '.$this->table;
        if($this->alias!= '' ){
            $sql .= ' as '.$this->alias;
        }
        $sql .= ' '.$this->leftJoin;
        if($this->where != 'where (1 = 1)')
        {
            $sql .= ' '.$this->where;
        }
        $sql .= ' '.$this->order;
        $sql .= ' '.$this->limit;
//        var_dump($sql);
        return $sql;

    }
    /**
     * 
     * 插入新数据操作
     */
    public function insert($data)
    {
        // $keys = array_keys($data);
        // $values = array_values($data);
        // 循环data的所有键值
     
        if(is_array($data)){
            foreach ($data as $keys=> $values) {
                $key .= ','. $keys;
                $value .= ',"' . $values.'"';
                # code...
            }
            $key = substr($key,1);
            $value = substr($value,1);
            $sql =  'insert  into '.$this->table.' ('.$key. ') values ( '. $value .')';
            $stmt = $this->db->prepare($sql);
            $res = $stmt->execute();
            return $res;
        }else{
            
        }   
    }

    /**
     * 执行 CUD 操作
     */

    /**
     * @return Db
     * 接口开放数据库实例
     */
    public static function connect_database()
    {
        if (empty($config)){
            self::$dbCofig = Config::getInstance()->getConfig('database.mysql');
        }
        if (self::$db_instance == null) {
            self::$db_instance = new self();
        }
        return self::$db_instance;
    }
}