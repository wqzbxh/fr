<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/12
 * Time:  10:18
 */

namespace libs\core;
/**
 * 反射机制处理
 * 后续优化:依赖注入的对象下还有对象,则进行递归调用exec(),
 *
 */
class Reflection
{
    /**
     * 根据给定的类名和方法名执行反射机制
     * @param string $class_name 类名
     * @param string $method 方法名
     * @return mixed 方法执行结果
     */
    public static function exec($class_name, $method)
    {
        if (empty($class_name) || empty($method)) {
            // 如果类名或方法名为空，抛出异常
            return  Message::ResponseMessage(421,);
        }

        // 根据给定的类名创建一个ReflectionClass实例，用于检查类及其属性、方法
        $reflectionInstance  = new \ReflectionClass($class_name);
        // 获取该类的构造函数，如果有的话。我们需要这个来创建该类的一个新实例。
        $constructor = $reflectionInstance->getConstructor();
        // 获取构造函数的参数列表。
        $constructorParam = self::getParams($constructor);
        // 用给定的参数创建一个新的类实例。
        $instance = $reflectionInstance->newInstanceArgs($constructorParam) ;

        // 根据给定的类名和方法名创建一个ReflectionMethod实例，这允许我们检查该方法及其参数、返回值等。

        $reflectMethod = new \ReflectionMethod($class_name, $method);

        // 获取该方法的参数列表。
        $methodparam = self::getParams($reflectMethod);

        try {
            // 调用该方法并返回执行结果
            $res = $reflectMethod->invokeArgs($instance,$methodparam);
            return $res;
        } catch (\Exception $e) {
            // 如果执行invokeArgs过程中发生异常，
            return  Message::ResponseMessage(421,);
        }
    }

    /**
     * 获取参数信息
     * @param ReflectionFunctionAbstract $reflectInfo 反射对象实例
     * @return array 参数数组
     */
    public static function getParams($reflectInfo)
    {
        $returnParams= [];
        // 如果反射对象存在且有参数，则获取参数信息
        if($reflectInfo && $reflectInfo->getNumberOfParameters() > 0){
            $reflectParams = $reflectInfo->getParameters();

            foreach ($reflectParams as $param)
            {
                // 获取参数的类型以及参数的名称
                $reflectParamType = $param->getType();

                if(is_object($reflectParamType)){
                    // 如果参数是对象类型，则获取参数的类名
                    $param_class_name = $reflectParamType->getName();
                    // 实例化并且存入返回数组中
                    $returnParams[] = new $param_class_name();
                }else{
                    // 如果参数不是对象类型，则视为普通类型
                    if($param->isDefaultValueAvailable()){
                        // 如果有默认值，则把默认的值存入返回数组
                        $returnParams[] = $param->getDefaultValue();
                    }else{
                        // 如果没有默认值，则认为是null，无默认值
                        $returnParams[] = null;
                    }
                }
            }
        }
        //返回参数
        return $returnParams;
    }
}