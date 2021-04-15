<?php

namespace Statements;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class IfElseTest extends TestCase
{
    // [一个关于if else容易迷惑的问题](https://mp.weixin.qq.com/s/ilfoYetC-tLaKAoCdtvdVg)
    // if...else...label的使用
    // 也就是说，通过在else里加语句这种label写法，把if...else...变成了顺序执行。这种语法糖知道就行了，还是少用为好，结构不清晰
    public function test1(UserInfo $userInfo): UserInfo
    {
        $a = true;
        if ($a) {
            echo true;
        } else {
            lable:
        echo false;
        }
    }

    public function test2()
    {
        $a = true;
        if ($a) {
            echo 'true';
        } else {
            label:;  //单独的一条语句
        }
        echo 'false';
    }
}

interface UserInfo
{
}
