<?php

namespace Base\DataType\Arrays;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class ArrayReduceTest extends TestCase
{
    private $arr = [1, 2, 3, 4, 5];

    // 向用户自定义函数发送数组中的值，并返回一个字符串
    public function testReduce1()
    {
        $res = $this->reduce1($this->arr);
        dd($res);
    }

    public function testReduce2()
    {
    }

    /**
     * @param $list
     *
     * @return mixed
     */
    public function reduce1($list)
    {
        // $arr
        // $func 函数名称
        // $init 发送到函数的初始值
        $sum = array_reduce($list, function ($result, $v) {
            dump($result);

            return $result + $v;
        });

        return $sum;
    }

    public function reduce2($arr)
    {
        return array_reduce($arr, function ($result, $v) {
            return $result . ',' . $v['id'];
        });
    }
}
