<?php

include __DIR__ . '/../vendor/autoload.php';

//ini_set("memory_limit","200M");
////生成器
//function makerange($length){
//    $ret = [];
//    for($i =1;$i<$length;$i++){
//        $ret[] = $i;
//    }
//    return $ret;
//}
//
//function makerange_g($length){
//    for($i =1;$i<$length;$i++){
//        yield $i;
//    }
//}
//
//$myfile = fopen("testfile.txt", "w");
////$re = makerange(1000000);
//$re = makerange_g(1000000);
//foreach($re as $item){
//    fwrite($myfile, $item . PHP_EOL);
//}
//echo memory_get_usage() / 1024 / 1024; //打印到此处内存的占用量

class Demo1
{
    public function old($arr)
    {
        foreach ($arr as $key => $val) {
            dd($val);
        }
    }

    public function new($arr)
    {
        foreach ($arr as $key => $val) {
            yield $val;
        }
    }
}

//$demo1 = new Demo1();
//$ass = ['1', '2', '3', '4'];
//dd($demo1->old($ass));
//dd($demo1->new($ass));

class Demo2
{
    public function xrange($start, $limit, $step = 1)
    {
        for ($i = $start; $i <= $limit; $i += $step) {
            yield $i + 1 => $i; // 关键字 yield 表明这是一个 generator
        }
    }

    public function ass()
    {
        foreach ($this->xrange(0, 10, 2) as $key => $val) {
            printf("%d %d\n", $key, $val);
        }
    }
}

//$demo2 = new Demo2();
//dd($demo2->ass());

// [PHP中被忽略的性能优化利器：生成器 - 严颖专栏 - SegmentFault 思否](https://segmentfault.com/a/1190000012334856)
class Demo3
{
    public function old($num)
    {
        $data = [];
        for ($i = 0; $i < $num; ++$i) {
            $data[] = time();
        }

        return $data;
    }

    public function new($num)
    {
        for ($i = 0; $i < $num; ++$i) {
            yield time();
        }
    }

    public function res($flag)
    {
        if ('old' == $flag) {
            $res = $this->old(10);
        }

        foreach ($res as $val) {
            sleep(1);
            echo $val;
        }
    }

    // yield不是返回值，是产出值；
}

class Demo4
{
    public function gen($max)
    {
        for ($i = 0; $i < $max; ++$i) {
//            yield $i;
            echo yield $i;
        }
    }
}

$demo4 = new Demo4();
dd($demo4->gen(5));
