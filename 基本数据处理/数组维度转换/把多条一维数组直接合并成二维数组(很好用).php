<?php

/**
 * @see https://blog.csdn.net/fdipzone/article/details/78070334
 *
 * 将多个一维数组合拼成二维数组（使用的时候，注意$key的使用；）
 *
 * @param array $keys 定义新二维数组的键值，每个对应一个一维数组
 * @param array $args 多个一维数组集合
 *
 * @return array
 */
function array_merge_more($keys, ...$arrs)
{

    // 检查参数是否正确
    if (!$keys || !is_array($keys) || !$arrs || !is_array($arrs) || count($keys) != count($arrs)) {
        return [];
    }

    // 一维数组中最大长度
    $max_len = 0;

    // 整理数据，把所有一维数组转重新索引
    for ($i = 0,$len = count($arrs); $i < $len; ++$i) {
        $arrs[$i] = array_values($arrs[$i]);

        if (count($arrs[$i]) > $max_len) {
            $max_len = count($arrs[$i]);
        }
    }

    // 合拼数据
    $result = [];

    for ($i = 0; $i < $max_len; ++$i) {
        $tmp = [];
        foreach ($keys as $k => $v) {
            if (isset($arrs[$k][$i])) {
                $tmp[$v] = $arrs[$k][$i];
            }
        }
        $result[] = $tmp;
    }

    return $result;
}

$arr1 = ['fdipzone', 'terry', 'alex'];
$arr2 = [18, 19, 20];
$arr3 = ['programmer', 'designer', 'tester'];

$keys = ['name', 'age', 'profession'];

$result = array_merge_more($keys, $arr1, $arr2, $arr3);

print_r($result);
