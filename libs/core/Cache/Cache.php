<?php

namespace libs\core\Cache;

class Cache {
    private $cache_dir = "./runtime/cache/";
    private $cache_time = 3600; // 缓存时间，默认为1小时

    public function __construct() {
        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 0777, true);
        }
    }

    // 设置缓存时间
    public function setCacheTime($time) {
        $this->cache_time = $time;
    }

    // 获取缓存时间
    public function getCacheTime() {
        return $this->cache_time;
    }

    // 生成缓存文件名
    private function getCacheFileName($key) {
        return $this->cache_dir . md5($key);
    }

    // 检查缓存是否存在
    public function has($key) {
        $filename = $this->getCacheFileName($key);
        if (file_exists($filename)) {
            $mtime = filemtime($filename);
            if (time() - $mtime <= $this->cache_time) {
                return true;
            } else {
                $this->delete($key);
            }
        }
        return false;
    }

    // 获取缓存值
    public function get($key) {
        if ($this->has($key)) {
            $filename = $this->getCacheFileName($key);
            return unserialize(file_get_contents($filename));
        }
        return null;
    }

    // 设置缓存值
    public function set($key, $value) {
        $filename = $this->getCacheFileName($key);
        file_put_contents($filename, serialize($value));
    }

    // 删除缓存
    public function delete($key) {
        $filename = $this->getCacheFileName($key);
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    // 清空缓存目录
    public function clear() {
        $files = glob($this->cache_dir . "*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

