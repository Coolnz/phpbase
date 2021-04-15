<?php

namespace Base\DataType\Arrays;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class ArrayFilterTest extends TestCase
{
    public function testFilter1()
    {
        $arr = [1, 2, 3];
        dd($this->filter1($arr));
    }

    /**
     * 把$arr as $key => $val的改写成array_filter()；
     * 不需要管$key；直接操作$val的值就可以了；.
     *
     * @param $arr
     *
     * @return array
     */
    public function filter1($arr)
    {
        return array_filter($arr, function ($v) {
            return $v > 1;
        });
    }
}
