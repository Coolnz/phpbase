<?php

require '../vendor/autoload.php';

$tip = ['aaa', 'bbb', 'ccc'];
function handle(...$tip)
{
    return $tip;
}

function test($a, $b, $c)
{
    return "$a, $b, $c";
}

$test1 = test($tip[0], $tip[1], $tip[2]);
$test2 = test(...$tip);


dd($test1, $test2, handle($tip));

//$tes1和$test2只是调用方法不同；同一个索引数组里的多个元素，直接使用PHP的可变参数去调用；

$test3 = handle(...$tip);

//dd($test1, $test2, $test3);

//dd(...$test2);

/**
 * 函数定义的时候变量前使用 ... 操作符来表示这是一个可变参数，
 * 如果你传递了2个或者更多的参数，那么这些参数会被添加到这个数组。
 *
 * @param $transform
 * @param mixed ...$strings
 *
 * @return mixed
 */
function concatenate($transform, ...$strings)
{
    $string = '';
    foreach ($strings as $piece) {
        $string .= $piece;
    }

    return $transform($string);
}

//dd(concatenate('strtoupper', "I'd ", 'like ', 4 + 2, ' apples'));

//参数拆包允许我们声明传入的参数数组，并且参数拆包允许我们传递一个数组到一个函数，在函数内部自动拆包；

function concatenate2()
{
    $mail[] = 'hi there';
    $mail[] = 'thanks';

    return "...$mail";
}
dd(concatenate2());

//使用func_num_args(), func_get_arg(), func_get_args()函数实现；

//把...$ins当做数组使用就可以了；
function sum(int ...$ins)
{
    return array_sum($ins);
}

dd(sum(2, 3, 4));
