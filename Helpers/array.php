<?php

if (!function_exists('arrayInsert')) {
    function arrayInsert(&$arr, $position, $insertArr)
    {
        $first_array = array_splice($arr, 0, $position);
        $arr = array_merge($first_array, $insertArr, $arr);

        return $arr;
    }
}

if (!function_exists('tda2oda')) {
    /**
     * 用array_reduce()实现二维转一维；.
     *
     * array_merge把相同字符串键名的数组覆盖合并，所以必须先用array_value取出值后，再合并；
     */
    function tda2oda(array $items): array
    {
        $result = array_reduce($items, function ($result, $value) {
            return array_merge($result, array_values($value));
        }, []);

        return $result;
    }
}

// 多维数组转一维数组
if (!function_exists('mda2oda')) {
    function mda2oda(array $items): array
    {
        $result = [];
        array_walk_recursive($items, function ($value) use (&$result) {
            array_push($result, $value);
        });

        return $result;
    }
}

if (!function_exists('currentAndNext')) {
    /**
     * 取出关联数组的相邻元素.
     *
     * @param $array
     */
    function currentAndNext($array): array
    {
        while ($current = current($array)) {
            $next = next($array);

            if (false != $next) {
                return [$current, $next];
            }
        }
    }
}

// 去重数组中的重复元素，支付二维数组，array_unique()只支持一维数组
function arrUnique($array)
{
    sort($array);
    $tem = '';
    $temarray = [];
    $j = 0;
    for ($i = 0; $i < count($array); ++$i) {
        if ($array[$i] != $tem) {
            $temarray[$j] = $array[$i];
            ++$j;
        }
        $tem = $array[$i];
    }

    return $temarray;
}

/**
 * 删除数组中的指定元素.
 *
 * @param $arr
 * @param $element
 */
function arrayRemoveElement(&$arr, $element): array
{
    if (in_array($element, $arr)) {
        array_splice($arr, array_search($element, $arr), 1);
    }

    return $arr;
}

// 二维数组转字符串
function tdaToString(array $arr): string
{
    if (is_array($arr)) {
        return implode(',', array_map('tdaToString', $arr));
    }

    return '';
}

if (!function_exists('arrRandVal')) {
    function arrRandVal(array $arr)
    {
        return $arr[array_rand($arr)];
    }
}

if (!function_exists('delByValue')) {
    function delByValue($arr, $value): array
    {
        if (!is_array($arr)) {
            return $arr;
        }
        foreach ($arr as $key => $val) {
            foreach ($val as $k => $v) {
                if ($v == $value) {
                    unset($arr[$key]);
                }
            }
        }

        return $arr;
    }
}

if (!function_exists('jsonEncode')) {
    function jsonEncode(array $arr): string
    {
        return json_encode($arr);
    }
}

if (!function_exists('arrayToString')) {
    function arrayToString($arr)
    {
        if (is_array($arr)) {
            return implode(',', array_map('arrayToString', $arr));
        }

        return $arr;
    }
}

if (!function_exists('combineSameKey')) {
    // 合并相同的key，把二维数组转三维
    function combineSameKey($array, $combineKey)
    {
        $result = [];
        foreach ($array as $key => $info) {
            $result[$info[$combineKey]] = $info;
        }

        return $result;
    }
}

if (!function_exists('cvtJsToArr')) {
    function cvtJsToArr(string $json)
    {
        return json_decode($json, true);
    }
}

/**
 * @see https://blog.csdn.net/fdipzone/article/details/78070334
 *
 * 将多个一维数组合拼成二维数组（使用的时候，注意$key的使用；）
 *
 * @param array $keys 定义新二维数组的键值，每个对应一个一维数组
 * @param array $args 多个一维数组集合
 */
function arrMergeMore($keys, ...$args): array
{

    // 检查参数是否正确
    if (!$keys || !is_array($keys) || !$args || !is_array($args) || count($keys) != count($args)) {
        return [];
    }

    // 一维数组中最大长度
    $max_len = 0;

    // 整理数据，把所有一维数组转重新索引
    for ($i = 0,$len = count($args); $i < $len; ++$i) {
        $args[$i] = array_values($args[$i]);

        if (count($args[$i]) > $max_len) {
            $max_len = count($args[$i]);
        }
    }

    $result = [];

    for ($i = 0; $i < $max_len; ++$i) {
        $tmp = [];
        foreach ($keys as $k => $v) {
            if (isset($args[$k][$i])) {
                $tmp[$v] = $args[$k][$i];
            }
        }
        $result[] = $tmp;
    }

    return $result;
}

/**
 *  二维数组去除重复值
 *
 * 用array_map()重构了一下，为什么use要引入的变量是作为入参的$key，而不是声明的$res；
 *
 * @param $arr
 * @param $key
 */
function uniqueArr($arr, $key): array
{
    //建立一个目标数组
    $res = [];
    array_map(function ($value) use (&$key) {
        //查看是否有重复值
        if (isset($res[$value[$key]])) {
            //如果重复则销毁；
            unset($value[$key]);
        } else {
            $res[$value[$key]] = $value;
        }
    }, $arr);

    return $res;
}

/**
 * 对二维数组按照 title+pubscore 去重.
 *
 * @param $arr
 * @param $key1
 * @param $key2
 *
 * @return mixed
 */
function uniqueArrByKey($arr, $key1, $key2)
{
    $tmp_key = [];
    foreach ($arr as $key => $item) {
        if (in_array($item[$key1] . $item[$key2], $tmp_key)) {
            unset($arr[$key]);
        } else {
            $tmp_key[] = $item[$key1] . $item[$key2];
        }
    }

    return $arr;
}

// [[算法]PHP随机合并数组并保持原排序 - 韭白 - 博客园](https://www.cnblogs.com/shockerli/p/shuffle-merge-array.html)
// 随机合并两个数组并保持原数组的排序
function shuffleMergeArr($array1, $array2)
{
    $mergeArray = [];
    $sum = count($array1) + count($array2);
    for ($k = $sum; $k > 0; --$k) {
        $number = mt_rand(1, 2);
        if (1 == $number) {
            $mergeArray[] = $array2 ? array_shift($array2) : array_shift($array1);
        } else {
            $mergeArray[] = $array1 ? array_shift($array1) : array_shift($array2);
        }
    }

    return $mergeArray;
}
