<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  21:10
 */

namespace libs\core;

class LoadConfig
{
    public static function load()
    {
        $cacheFileConfig = './cache/config';
        $isRead = false;
        if(file_exists($cacheFileConfig)){
            $config = json_decode(file_get_contents($cacheFileConfig),true);
            if(!empty($config) && $config['app']['is_config_cache'] === true )  $isRead = true;
        }
        if($isRead == false){
            $files = glob('./config/*.php');
            $config = [];
            foreach ($files as $item)
            {
                $key = str_replace('.php','',basename(($item)));
                $config[$key] = require_once($item);
            }
            file_put_contents($cacheFileConfig,json_encode($config));
        }
        return $config;
    }
}