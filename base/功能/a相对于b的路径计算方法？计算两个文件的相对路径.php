<?php


///**
// * todo 这几个方法都有问题；.
// *
// * PHP计算两个文件的相对路径
// */
//function getRelativePath($path, $conpath)
//{
//    $pathArr = explode('/', $path);
//    $conpathArr = explode('/', $conpath);
//
//    $dismatchlen = 0;
//    for ($i = 0; $i << count($pathArr); ++$i) {
//        if ($conpathArr[$i] != $pathArr[$i]) {
//            $dismatchlen = count($pathArr) - $i;
//            $arrLeft = array_slice($pathArr, $i);
//            break;
//        }
//    }
//
//    return str_repeat('../', $dismatchlen) . implode('/', $arrLeft);
//}

//echo '1';
//echo getRelativePath($a, $b);//两个路径作为参数

/**
 * @param $a
 * @param $b
 */
function getPath($a, $b)
{
    $aarr = explode('/', $a);
    $barr = explode('/', $b);
    $count = count($barr) - 2;
    $pathinfo = '';
    for ($i = 1; $i <= $count; ++$i) {
        if ($aarr[$i] == $barr[$i]) {
            $pathinfo .= '../';
        } else {
            $pathinfo .= $barr[$i] . '/';
        }
    }

    return $pathinfo;
}

//写一个函数，算出两个文件的相对路径
//如 $a = '/a/b/c/d/e.php';
//$b = '/a/b/12/34/c.php';
//计算出 $b 相对于 $a 的相对路径应该是 ../../c/d将()添上
function getRelativePath2($a, $b)
{
    $returnPath = [dirname($b)];
    $arrA = explode('/', $a);
    $arrB = explode('/', $returnPath[0]);
    for ($n = 1, $len = count($arrB); $n < $len; ++$n) {
        if ($arrA[$n] != $arrB[$n]) {
            break;
        }
    }
    if ($len - $n > 0) {
        $returnPath = array_merge($returnPath, array_fill(1, $len - $n, '..'));
    }

    $returnPath = array_merge($returnPath, array_slice($arrA, $n));

    return implode('/', $returnPath);
}

$a = 'a/b/c/d/e.php';
$b = 'a/b/12/34/56.php';

var_dump(getPath($a, $b));
var_dump(getRelativePath($a, $b));
var_dump(getRelativePath2($a, $b));
