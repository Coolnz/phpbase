<?php

namespace Modifiers;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class FinalTest extends TestCase
{
    public function test1()
    {
        $math = new Math();
        echo $math;
    }
}
final class Math
{
    public static $pi = 3.14;

    public function __toString()
    {
        return '这是一个math类';
    }
}
