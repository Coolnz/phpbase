<?php

namespace MagicFunc;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class SleepAndWakeupTest extends TestCase
{
    // 反序列化操作之后，用来重新建立数据库连接，或者执行其他初始化操作
    public function __wakeup()
    {
        return '111';
    }

    // 用来提交未提交的数据，或者类似的清理操作
    public function __sleep()
    {
        return '111';
    }

    public function testSaW()
    {
        $se = 'O:14:"MagicFunc\User":3:{s:3:"age";s:1:"7";s:3:"sex";s:3:"man";s:4:"name";s:7:"Notyeat";}';

        $user = new User();
        $this->assertEquals($se, serialize($user));
    }
}

class User
{
    public $age = '7';
    public $sex = 'man';
    public $name = 'Notyeat';
}
