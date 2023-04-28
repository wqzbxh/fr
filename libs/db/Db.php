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
     * 添加查询条件
     *
     * @param mixed $where 查询条件，可以是字符串或者数组形式，数组形式支持多条件查询
     * @param string $sep 条件分隔符，默认为空
     * @param mixed $value 条件对应的值，默认为空字符串
     * @return self 返回当前类实例，用于链式调用
     */
    public function where($where, $sep = '', $value = '')
    {
        if (is_array($where)) { // 如果传入的查询条件是数组
            foreach ($where as $item) { // 遍历每个查询条件
                $this->where .= ' AND '; // 连接多个查询条件的关系符
                foreach ($item as $k => $v) { // 遍历每个查询条件的键值对
                    if ($k == 2) { // 如果键名为2，表示该键值对为条件的值
                        if (is_string($v)) { // 如果值为字符串类型，需要用双引号括起来
                            $v = '"' . $v . '"';
                        }
                    }
                    $this->where .= $v; // 连接每个查询条件的键值对
                }
            }
        } else { // 如果传入的查询条件是字符串
            if (is_string($value)) { // 如果条件对应的值为字符串类型，需要用双引号括起来
                $value = '"' . $value . '"';
            }
            $this->where .= ' AND ' . $where . ' ' . $sep . ' ' . $value; // 连接查询条件
        }
        $this->where = str_replace('(1 = 1) AND', '', $this->where); // 替换无意义的查询条件
        return self::$db_instance; // 返回当前类实例，用于链式调用
    }


    public function count()
    {
        $count = 0;
        try {
//            $sql = $this->getSql();
            $sql = 'select count(*) from '. $this->table .' '.  $this->leftJoin .' '. $this->where;
            var_dump($sql);
            $result =$this->queryNative($sql);
            var_dump($result);exit;
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
     * 添加别名
     * @param string $aliasName 别名名称
     * @return self 返回当前类实例，用于链式调用
     */
    public function alias($aliasName)
    {
        $this->alias = $aliasName; // 将传入的别名名称赋值给当前实例的别名属性
        return self::$db_instance; // 返回当前类实例，用于链式调用
    }
    /**
     * select方法用于执行查询操作，返回一个查询结果数组。
     * @return array 返回查询结果数组，如果查询出错则返回空数组。
     */
    public function select()
    {
        $list = [];
        try {
            $sql = $this->getSql(); // 获取组装好的SQL语句。
            $result = $this->db->query($sql); // 执行SQL查询语句。
            $list = $result->fetchAll();
        }catch (\Throwable $e){
            error_log('Database connection failure!' . $e->getMessage()); // 输出错误信息到日志文
            return $list; // 出错时返回空数组。
        }
        $this->free(); // 释放资源，关闭数据库连接。
        return $list; // 返回查询结果数组。
    }

    /**
     * 获取单行数据
     *
     * @return array 返回单行数据数组
     */
    public function get()
    {
        $list = [];
        try {
            $sql = $this->getSql(); // 获取 SQL 语句
            $result = $this->db->query($sql); // 执行 SQL 查询语句
            $list = $result->fetch(); // 获取单行数据
        }catch (\Throwable $e){
            die('Database connection failure!' . $e->getMessage()); // 抛出异常并输出错误信息
        }
        $this->free(); // 释放资源
        return $list; // 返回单行数据数组
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
     * 执行原生 SQL 查询
     *
     * @param string $sql SQL 查询语句
     * @param array $arrayValue 包含查询参数的数组，默认为空数组
     * @param bool $isset 是否返回多行结果，默认为 false，只返回第一行结果
     *
     * @return array 查询结果
     *
     * @throws \Exception 查询异常，返回异常信息
     */
    public function queryNative(string $sql , array $arrayValue = array() , bool $isset = false)
    {
        // 初始化结果集数组
        $list = [];
        try {
            // 准备 SQL 查询语句
            $stmt = $this->db->prepare($sql);
            // 判断是否是带有参数的 SQL 查询
            if(is_array($arrayValue) && count($arrayValue) == count($arrayValue,1) && !empty($arrayValue)){
                $stmt->execute($arrayValue);
            }else{
                $stmt->execute();
            }
            // 判断是否需要返回多行结果
            if($isset){
                $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }else{
                $list = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
        }catch (\Throwable $exception){
            // 抛出异常，提示查询错误信息
            throw new \Exception('查询异常,返回信息为:'.$exception->getMessage());
        }
        // 释放资源
        $this->free();
        // 返回查询结果
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

        return $sql;

    }
    /**
     *  insert方法用于向数据表中插入一条数据。
     * @param array $data 插入的数据，以关联数组形式传入，键为列名，值为插入的值。
     * @return bool 插入成功时返回true，插入失败时返回false。
     */

    public function insert($data)
    {
        if (empty($data) || !is_array($data)) { // 如果$data参数为空或者不是数组，则返回false。
            return false;
        }
        $keys = [];
        $values = [];
        foreach ($data as $key => $value) {
            $keys[] = $key;
            $values[] = $value;
        }
        $key_str = implode(',', $keys);
        $value_str = implode(',', array_fill(0, count($values), '?'));
        $sql = 'INSERT INTO ' . $this->table . ' (' . $key_str . ') VALUES (' . $value_str . ')';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            return true;
        } catch (PDOException $e) {
            error_log('Database insertion failure!' . $e->getMessage()); // 输出错误信息到日志文件。
            return false;
        }
    }
    /**
     * 插入多条记录
     *
     * @param array $data 待插入的数据，为一个二维数组，每个元素为一条记录的键值对
     * @return bool 插入成功返回true，否则返回false
     */
    public function insertMultiple($data)
    {
        // 如果数据为空，直接返回false
        if (empty($data)) {
            return false;
        }

        // 取出所有记录的键
        $keys = array_keys($data[0]);
        // 拼接成sql语句中的列名列表
        $columns = implode(',', $keys);

        // 拼接占位符，如"(?, ?, ?)" keys有多少元素重复多少个 ?, 然后删除最后面的? 形成 ?,?,?的形式
        $placeholders = rtrim(str_repeat('?,', count($keys)), ',');

        // 取出所有记录的值
        $values = [];
        foreach ($data as $item) {
            $values = array_merge($values, array_values($item));
        }

        // 拼接占位符，如"(?, ?, ?),(?, ?, ?)" 有多少条记录形成多少条(?, ?, ?)
        $placeholders = rtrim(str_repeat('(' . $placeholders . '),', count($data)), ',');

        // 拼接sql语句
        $sql = 'INSERT INTO ' . $this->table . ' (' . $columns . ') VALUES ' . $placeholders;

        // 执行sql语句
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute($values);

        return $res;
    }

    /**
     * 执行 CUD 操作
     */

    /**
     * @return Db
     * 接口开放数据库实例
     */
    public static function connect_database($database = 'database.mysql')
    {
        if (empty($config)){
            self::$dbCofig = Config::getInstance()->getConfig($database);
        }
        if (self::$db_instance == null) {
            self::$db_instance = new self();
        }
        return self::$db_instance;
    }
}