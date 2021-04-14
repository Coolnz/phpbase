<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-14
 * Time: 13:33
 */

/**
 * [php 数组去重，一维数组去重，二维数组去重 - Grace_的个人空间 - 开源中国](https://my.oschina.net/osgrace/blog/1334991)
 *
 */

/**
 * 一维数组去重，我们主要用两种方法来解决：
 * 1，array_unique();
 * 2，array_keys(array_flip());
 *
 * 那么，二维数组去重，怎么实现呢？
 */


/**
 *  二维数组去除重复值
 *
 * 用array_map()重构了一下，为什么use要引入的变量是作为入参的$key，而不是声明的$res；
 *
 * @param $arr
 * @param $key
 * @return array
 */
function arrayUnset($arr, $key){
	//建立一个目标数组
	$res = [];
	array_map(function($value) use (&$key){
		//查看是否有重复值
		if (isset($res[$value[$key]])) {
			//如果重复则销毁；
			unset($value[$key]);
		} else {
			$res[$value[$key]] = $value;
		}
	}, $arr);

	return $res;
}


/**
 *
 * 对二维数组按照 title+pubscore 去重
 *
 * @param $arr
 * @param $key1
 * @param $key2
 * @return mixed
 */
function uniqueByKey($arr, $key1, $key2) {
	$tmp_key = [];
	foreach ($arr as $key => $item) {
		if ( in_array($item[$key1].$item[$key2], $tmp_key) ) {
			unset($arr[$key]);
		} else {
			$tmp_key[] = $item[$key1].$item[$key2];
		}
	}

	return $arr;
}

//使用示例：
$arr = array(
	array('id' => 1, 'title' => 'a','pubscore'=>1),
	array('id' => 2, 'title' => 'a','pubscore'=>1),
	array('id' => 3, 'title' => 'b','pubscore'=>2),
	array('id' => 4, 'title' => 'c','pubscore'=>3),
	array('id' => 5, 'title' => 'd','pubscore'=>3),
);
var_dump(uniqueByKey($arr,'title','num'));








