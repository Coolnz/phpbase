<?php

namespace Base\DataType\Arrays;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class ArrayMapTest extends TestCase
{
    private $arr1 = [
        0 => ['sku_id' => '11', 'sku_amount' => 240],
        1 => ['sku_id' => '27', 'sku_amount' => 600],
    ];

    private $list = [3, 4, 5, 6, 7, 9];

    private $arr3 = [
        [
            'id' => 12,
            'name' => 'Karl',
        ],
        [
            'id' => 4,
            'name' => 'Franz',
        ],
        [
            'id' => 9,
            'name' => 'Helmut',
        ],
        [
            'id' => 10,
            'name' => 'Kurt',
        ],
    ];

    public function testMap1()
    {
        dd($this->map1($this->arr1));
    }

    public function testMap2()
    {
    }

    public function testMap3()
    {
    }

    public function map1($array)
    {
        //使用“&”取址符就可以赋值闭包外的变量了。
        $res = [];

        return array_map(function ($item) use (&$res) {
            $res[$item['sku_id']] = $item['sku_amount'];
        }, $array);
    }

    public function map2($list)
    {
        $res = array_map('floatval', $list);

        return $res;
    }

    /**
     * @param $key
     * @param $array
     *
     * @return array
     */
    public function map3($key, $array)
    {
        $ar = array_map(function ($element) use ($key) {
            $newArray = [];
            if (array_key_exists($key, $element)) {
                $newArray = $element[$key];
            }

            return $newArray;
        }, $array);

        return $ar;
    }

    /**
     * foreach转化为array_map().
     *
     * @param $arr
     *
     * @return bool|string
     */
    public function arr2str($arr)
    {
        $temp = array_map(function ($value) {
            return implode(',', $value);
        }, $arr);

        $t = '';
        array_map(function ($v) use (&$t) {
            $t .= "'" . $v . "'" . ',';
        }, $temp);
        $t = mb_substr($t, 0, -1);

        return $t;
    }
}
