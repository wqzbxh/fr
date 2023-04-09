<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/7
 * Time:  14:28
 */

namespace libs\core\Cache;

class Cache {
    //定义缓存目录
    private $cache_dir = "./runtime/cache/";
    //定义缓存事件默认一天
    private $cache_time = 86400; // 缓存时间，默认为1天

    public function __construct() {
        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 0777, true);
        }
    }

    /**
     * 设置缓存时间
     * @param $time
     * @return void
     */

    public function setCacheTime($time) {
        $this->cache_time = $time;
    }

    /**
     * 获取缓存时间
     * @return int
     */
    public function getCacheTime() {
        return $this->cache_time;
    }

    // 生成缓存文件名
    private function getCacheFileName($key) {
        return $this->cache_dir . md5($key);
    }

    /**
     *  检查缓存是否存在
     * @param $key
     * @return bool
     */
    public function has($key) {
        $filename = $this->getCacheFileName($key);
        if (file_exists($filename)) {
//           filemtime 修改其内容后返回指定文件的最后时间
            $mtime = filemtime($filename);
            if (time() - $mtime <= $this->cache_time) {
                return true;
            } else {
                $this->delete($key);
            }
        }
        return false;
    }

    /**
     * 获取缓存值
     * @param $key
     * @return mixed|null
     */

    public function get($key) {
        if ($this->has($key)) {
            $filename = $this->getCacheFileName($key);
            return unserialize(file_get_contents($filename));
        }
        return null;
    }

    /**
     * 设置缓存值
     * @param $key
     * @param $value
     * @return void
     */
    public function set($key, $value) {
        $filename = $this->getCacheFileName($key);
        file_put_contents($filename, serialize($value));
    }

    /**
     * 删除缓存
     * @param $key
     * @return void
     */
    public function delete($key) {
        $filename = $this->getCacheFileName($key);
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    /**
     * 清空缓存目录
     * @return void
     */
    public function clear() {
        $files = glob($this->cache_dir . "*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

