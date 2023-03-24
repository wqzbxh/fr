<?php
/**
 * Created by : phpstorm
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/3/13
 * Time:  22:19
 * 清除缓存文件
 */
file_put_contents('../cache/config', "");
file_put_contents('../cache/route', "");
echo 'clear success!';