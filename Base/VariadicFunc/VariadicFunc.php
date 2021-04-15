<?php

namespace Base\VariadicFunc;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class VariadicFunc extends TestCase
{
    public function testVf()
    {
        $res = $this->sum('array_sum', 1, 2, 3, 4, 5);
        $this->assertEquals(15, $res);
    }

    public function sum($transform, ...$strings)
    {
        return $transform($strings);
    }

    public function concatenate($transform, ...$strings)
    {
        $string = '';

        dump($strings);
        foreach ($strings as $piece) {
            $string .= $piece;
        }

        return $transform($string);
    }

    public function testVf2()
    {
        $arr[] = 'Hi there ';
        $arr[] = 'Thanks for registering, hope you like it';

        // 参数解包，也就是把数组转字符串
        $res = $this->concatenate('strtoupper', ...$arr);

        $this->assertEquals('HI THERE THANKS FOR REGISTERING, HOPE YOU LIKE IT', $res);
    }

    
}
