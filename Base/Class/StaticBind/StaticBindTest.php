<?php

namespace Base\ClassPath\StaticBind;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class StaticBindTest extends TestCase
{
    // [对 PHP 后期静态绑定的理解 | Laravel China 社区](https://learnku.com/articles/8964/understanding-of-static-binding-at-the-later-stage-of-php)
    public function testSb()
    {
        C::test();
    }
}
class A
{
    public static function foo()
    {
        static::who();
    }

    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}

class B extends A
{
    public static function test()
    {
        A::foo();
        parent::foo();
        self::foo();
    }

    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}
class C extends B
{
    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}
