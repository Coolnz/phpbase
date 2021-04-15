<?php

namespace Base\ClassPath\Anonymous;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class AnonymousTest extends TestCase
{
    public function testAnonymous()
    {
        // 匿名类也可以使用抽象类，接口类，trait
        dd(new class(10) extends SomeClass implements SomeInterface {
            use SomeTrait;

            private $num;

            public function __construct($num)
            {
                $this->num = $num;
            }
        });
    }
}

class SomeClass
{
}
interface SomeInterface
{
}
trait SomeTrait
{
}

/**
 * @coversNothing
 */
class AnonymousTest2 extends TestCase
{
    // todo 还是有问题
    public function testFunc2()
    {
        $res = (new Anonymous())->func2()->func3();
        dd($res);
    }
}

class Anonymous
{
    protected $prop2 = 2;
    private $prop = 1;

    public function func1()
    {
        return 3;
    }

    public function func2()
    {
        dump($this->prop);

        return new class($this->prop) extends Anonymous {
            private $prop3;

            public function __construct($prop)
            {
                $this->prop3 = $prop;
            }

            public function func3()
            {
                return $this->prop2 + $this->prop3 + $this->func1();
            }
        };
    }
}
