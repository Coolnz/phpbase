<?php


namespace Base\Func;

use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    function testJson1()
    {
        $arr = [1, 2, 3, 4];
        // 输出一个对象
        $ret = json_encode($arr, JSON_FORCE_OBJECT);
        dd($ret);
    }

    // json_encode
    // 索引数组，返回数组
    // 关联数组，返回对象
    function testJsonEncode()
    {
        $slice = [1, 2, 3, 4];
        $map = ['name' => 'lu', 'age' => 18];

        $resSlice = json_encode($slice);
        $resMap = json_encode($map);

        dd($resSlice, $resMap);
    }

    function testJsonDecode()
    {
        $arr = [1, 2, 3, 4];
        $json = json_encode($arr);

        $res = json_decode($json);
        $ret = json_decode($json, true);

        // todo 不加true返回对象，加上true返回数组
        $this->assertEquals($res, $ret);
    }
}
