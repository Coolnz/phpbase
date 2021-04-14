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
     *
     * @param array $items
     *
     * @return array
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
     *
     * @return array
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
 *
 * @return array
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
