<?php

namespace MagicFunc;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class CallTest extends TestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    //魔术方法 试着少写一个_看下

    public function __call($name, $args)
    {
        return sprintf('%s-%s', $name, 'success');
    }

    public function eat()
    {
    }

    public function sleep()
    {
    }

    public function testCall()
    {
        $call = new self();
        $call->test();
        $this->assertEquals('test-success', $call->test());
    }
}

/**
 * @coversNothing
 */
class CallTest2 extends TestCase
{
    public $str = '';

    public function __construct($str, ?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->str = $str;
    }

    public function __call($name, $argument)
    {
        $ret = '';
        switch ($name) {
            case 'trim':
                $new_s = trim($this->str);
                $ret = new self($new_s);
                break;
            case 'strlen':
                $ret = mb_strlen($this->str);
                break;
            default:
        }

        return $ret;
    }

    public function testCall2()
    {
        $s = new self('   codeman   ');
        $length = $s->trim()->strlen();
        $this->assertEquals(7, $length);
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
