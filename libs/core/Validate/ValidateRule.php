<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/3/25
 * Time: 19:20
 */

namespace libs\core\Validate;

class ValidateRule
{
    /**
     * 验证字段是否存在
     * @param $data
     * @param $key
     * @return bool
     */
    public static function require($data,$key,$value = false)
    {
        return isset($data[$key]);
    }

    /**
     * 验证字段为数字INT型  强制
     * @param $data
     * @param $key
     * @return bool
     */
    public static function force_int($data,$key,$value = false)
    {

        if (isset($data[$key]))  return is_int((int)$data[$key]);
        return true;
    }


    /**
     * 验证字段为数字INT型  非强制
     * @param $data
     * @param $key
     * @return bool
     */
    public static function int($data,$key,$value = false)
    {
        if (isset($data[$key])){
            return is_int((int)$data[$key]);
        }
        return true;
    }

    /**
     * 最小值判断
     * @param $data
     * @param $key
     * @param $value
     * @return bool
     */
    public static function min($data,$key,$value = false)
    {
        if (isset($data[$key])){
            return $data[$key] > $value;
        }
        return true;
    }

    /**
     * 最大值判断
     * @param $data
     * @param $key
     * @param $value
     * @return bool
     */
    public static function max($data,$key,$value = false)
    {
        if (isset($data[$key])){
            return $data[$key] < $value;
        }
        return true;
    }

    /**
     * @param $data
     * @param $key
     * @param $value
     * @return bool|void
     */
    public static function minLen($data,$key,$value = false)
    {
        if (isset($data[$key])){
            return strlen($data[$key]) > $value;
        }
        return true;
    }

    public static function maxLen($data,$key,$value = false)
    {
        if (isset($data[$key])){
            return strlen($data[$key]) <  $value;
        }
        return true;
    }

    /**
     * 验证时间格式
     */
    public function datetime($data,$key,$value = false)
    {

        if (isset($data[$key])){
            preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $data);
        }
        return true;
    }
}