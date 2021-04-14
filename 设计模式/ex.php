<?php

//$arr = [1, 2, 3];
//function trans($arr, $num)
//{
//	$str = implode(',', $arr);
//	$repeat = str_repeat($str.',', $num);
////	var_dump($repeat);
//
//	$array = explode(',', $repeat);
//	$sanitize = array_filter($array);
//	var_dump($sanitize);
//}
//
//var_dump(trans($arr, 3));

$arr = [1, 2, 3];
foreach ($arr as &$v) {
    //nothing todo.
    var_dump($arr);
}
foreach ($arr as $v) {
    //nothing todo.
    var_dump($arr);
}
var_export($arr);
//output:array(0=>1,1=>2,2=>2)
