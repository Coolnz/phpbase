<?php

//两个有序int集合，是否有相同元素的最优算法；	array_intersect的一部分；

//将一个数组中的元素随机（打乱）；	shuffle()打乱原数组；

//给一个有数组和字母的字符串，让连着的数字和字母对应；

//求n以内的质数（质数的定义：在大于1的自然数中，除了1和它本身以外，无法被其他自然数整除的数）
//约瑟夫环问题（）

//如何快速寻找一个数组里最小的1000个数
//二分查找（如何在有序的数组中找到一个数的位置）
//给定一个有序整数序列，找出绝对值最小的元素
//找出有序数组中随机3个数的和，为0的所有情况；
//写一个PHP函数，求任意n个正负整数里面最大的连续和，要求算法时间复杂度尽可能低；（动态规划）

//用PHP写一个函数，获取一个文本文件最后n行内容，要求尽可能效率高，尽可能跨平台使用；
function tail($file, $num)
{
    $fp = fopen($file, 'r');
    $pos = -2;
    $eof = '';
    $head = false;   //当总行数小于Num时，判断是否到第一行了
    $lines = [];
    while ($num > 0) {
        while (PHP_EOL != $eof) {
            if (0 == fseek($fp, $pos, SEEK_END)) {    //fseek成功返回0，失败返回-1
                $eof = fgetc($fp);
                --$pos;
            } else {                            //当到达第一行，行首时，设置$pos失败
                fseek($fp, 0, SEEK_SET);
                $head = true;                   //到达文件头部，开关打开
                break;
            }
        }
        array_unshift($lines, str_replace(PHP_EOL, '', fgets($fp)));
        if ($head) {//这一句，只能放上一句后，因为到文件头后，把第一行读取出来再跳出整个循环
            break;
        }
        $eof = '';
        --$num;
    }
    fclose($fp);

    return $lines;
}

//PHP解决多进程同时写一个文件的问题
function write($str)
{
    $fp = fopen($file, 'a');
    do {
        usleep(100);
    } while (!flock($fp, LOCK_EX));
    fwrite($fp, $str . PHP_EOL);
    flock($fp, LOCK_UN);
    fclose($fp);
}

//验证IP是否正确
function check_ip($ip)
{
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return false;
    }

    return true;
}
//验证日期是否合理
function check_datetime($datetime)
{
    if (date('Y-m-d H:i:s', strtotime($datetime)) === $datetime) {
        return true;
    }

    return false;
}

//写一个正则表达式，过滤JS脚本（并且把script标签及其内容一起去掉）
//$text = '<script>alert('XSS')</script>';
//$pattern = '<script.*>.*<\/script>/i';
//$text = preg_replace($pattern, '', $text);

//设计一个秒杀系统（用Redis的队列）
$ttl = 4;
$random = mt_rand(1, 1000) . '-' . gettimeofday(true) . '-' . mt_rand(1, 1000);

$lock = fasle;
while (!$lock) {
    $lock = $redis->set('lock', $random, ['nx', 'ex' => $ttl]);
}

if ($redis->get('goods.num') <= 0) {
    echo '秒杀已经结束';
    //删除锁
    if ($redis->get('lock') == $random) {
        $redis->del('lock');
    }

    return false;
}

$redis->decr('goods.num');
echo '秒杀成功';
//删除锁
if ($redis->get('lock') == $random) {
    $redis->del('lock');
}

return true;
//请设计一个实现方法，可以给某个IP找到对应的省和市，要求效率尽可能的高；
//ip2long，把所有城市的最小和最大Ip录进去
$redis_key = 'ip';
$redis->zAdd($redis_key, 20, '#bj'); //北京的最小IP加#
$resid->zAdd($redis_key, 30, 'bj'); //最大IP

function get_ip_city($ip_address)
{
    $ip = ip2long($ip_address);

    $redis_key = 'ip';
    $city = zRangeByScore($redis_key, $ip, '+inf', ['limit' => [0, 1]]);
    if ($city) {
        if (0 === mb_strpos($city[0], '#')) {
            echo '城市不存在!';
        } else {
            echo '城市是' . $city[0];
        }
    } else {
        echo '城市不存在!';
    }
}
