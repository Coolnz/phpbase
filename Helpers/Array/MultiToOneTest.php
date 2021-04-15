<?php

namespace Helpers\Arrays;

use PHPUnit\Framework\TestCase;

// 多维转一维
/**
 * @coversNothing
 */
class MultiToOneTest extends TestCase
{
    /**
     * 深度转化；使用array_walk_recursive()
     * 任何多维数组都能转一维数组；.
     *
     * [PHP二维数组（或任意维数组）转换成一维数组的方法汇总 - 歪麦博客](https://www.awaimai.com/2064.html)
     */
    public function deepFlatten($items)
    {
        $result = [];
        array_walk_recursive($items, function ($value) use (&$result) {
            array_push($result, $value);
        });

        return $result;
    }

    /**
     * 使用循环+递归实现多维转一维的深度转化.
     *
     * @param $items
     *
     * @return array
     */
    public function dF($items)
    {
        $result = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } else {
                $result = array_merge($result, dF($item));
            }
        }

        return $result;
    }
}
