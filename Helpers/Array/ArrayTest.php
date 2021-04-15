<?php

namespace Helpers\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class ArrayTest extends TestCase
{
    public function testCombineSameKey()
    {
        $infos = [
            [
                'a' => 36,
                'b' => 'xa',
                'c' => '2015-08-28 00:00:00',
                'd' => '2015/08/438488a00b3219929282e3652061c2e3.png',
            ],
            [
                'a' => 3,
                'b' => 'vd',
                'c' => '2015-08-20 00:00:00',
                'd' => '2015/08/438488a00b3219929282e3652061c2e3.png',
            ],
            [
                'a' => 6,
                'b' => 'wwe',
                'c' => '2015-08-28 00:00:00',
                'd' => '2015/08/438488a00b3219929282e3652061c2e3.png',
            ],
            [
                'a' => 36,
                'b' => 'se',
                'c' => '2015-08-28 00:00:00',
                'd' => '2015/08/438488a00b3219929282e3652061c2e3.png',
            ],
            [
                'a' => 6,
                'b' => 'aw',
                'c' => '2015-08-28 00:00:00',
                'd' => '2015/08/438488a00b3219929282e3652061c2e3.png',
            ],
            [
                'a' => 36,
                'b' => 'bv',
                'c' => '2015-08-28 00:00:00',
                'd' => '2015/08/438488a00b3219929282e3652061c2e3.png',
            ],
            [
                'a' => 12,
                'b' => 'xx',
                'c' => '2015-08-27 00:00:00',
                'd' => '2015/08/438488a00b3219929282e3652061c2e3.png',
            ],
        ];
        combineSameKey($infos, 'a');
    }

    public function testArrMergeMore()
    {
        $keys = ['name', 'age', 'prof'];
        $arr1 = ['tom', 'terry', 'alex'];
        $arr2 = [18, 19, 20];
        $arr3 = ['programmer', 'designer', 'tester'];

        $result = arrMergeMore($keys, $arr1, $arr2, $arr3);

        $ret = [
            ['name' => 'tom', 'age' => 18, 'prof' => 'programmer'],
            ['name' => 'terry', 'age' => 19, 'prof' => 'designer'],
            ['name' => 'alex', 'age' => 20, 'prof' => 'tester'],
        ];

        dump($result);
        $this->assertEquals($ret, $result);
    }

    public function testUniqueArr()
    {
        $arr = [
            ['id' => 1, 'title' => 'a', 'score' => 1],
            ['id' => 2, 'title' => 'a', 'score' => 1],
            ['id' => 3, 'title' => 'b', 'score' => 2],
            ['id' => 4, 'title' => 'c', 'score' => 3],
            ['id' => 5, 'title' => 'd', 'score' => 3],
        ];

        $res = uniqueArr($arr, 'title');
        dd($res);
    }

    public function testUniqueArrByKey()
    {
        $arr = [
            ['id' => 1, 'title' => 'a', 'score' => 1],
            ['id' => 2, 'title' => 'a', 'score' => 1],
            ['id' => 3, 'title' => 'b', 'score' => 2],
            ['id' => 4, 'title' => 'c', 'score' => 3],
            ['id' => 5, 'title' => 'd', 'score' => 3],
        ];

        $res = uniqueArrByKey($arr, 'title', 'score');

        dd($res);
    }

    public function testShuffleMergeArr()
    {
        $arr1 = [1, 2, 3, 4];
        $arr2 = ['a', 'b', 'c', 'd', 'e'];

        $res = shuffleMergeArr($arr1, $arr2);

        dd($res);
    }
}
