<?php

namespace MultiThread;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class LocalPcntlTest extends TestCase
{
    public function testSub()
    {
        $oldstr = '你好，我是你爸爸';
        $str_to_insert = 'hi';
        $pos = '6'; //中文占三个字符位置，2*3 = 6
        $newStr = substr_replace($oldstr, $str_to_insert, $pos, 0);

        $this->assertEquals('你好hi，我是你爸爸', $newStr);
    }

    public function pcntl()
    {
        $pid = pcntl_fork(); //父进程和子进程都会执行下面代码
        if (-1 == $pid) {
            //错误处理：创建子进程失败时返回-1.
            exit('could not fork');
        } elseif ($pid) {
            //父进程会得到子进程号，所以这里是父进程执行的逻辑
            pcntl_wait($status);
            //等待子进程中断，防止子进程成为僵尸进程。
        }
        //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
    }
}
