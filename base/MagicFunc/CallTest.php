<?php

namespace MagicFunc;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class CallTest extends TestCase
{
    public $name = '';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->name = $name;
    }

    //魔术方法 试着少写一个_看下

    public function __call($name, $args)
    {
        echo sprintf('%s-%s', $name, 'success');
    }

    public function eat()
    {
    }

    public function sleep()
    {
    }

    public function testCall()
    {
        $call = new self('111');
        $call->test();
        $this->assertEquals('test-success', $call->test());
    }
}

/**
 * @coversNothing
 */
class CallStaticTest extends TestCase
{
    protected $arr = [];

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    public function success()
    {
        return 'success';
    }

    public function testCallStatic()
    {
        // 用静态方式调用普通方法
        $this->assertEquals('success', CallTest::success());
    }
}
