<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-14
 * Time: 09:14
 */
require_once __DIR__. '/../vendor/autoload.php';

$arr1 = array(
	array(
		'id' => 1,
		'user_name'=>'test1'
	),
	array(
		'id' => 2,
		'user_name'=>'test2'
	),
	array(
		'id' => 3,
		'user_name'=>'test3'
	)
);
$arr2 = array(
	array(
		'id' => 1,
		'shop_name'=>'shop1'
	),
	array(
		'id' => 5,
		'shop_name'=>'shop2'
	),
	array(
		'id' => 3,
		'shop_name'=>'shop3'
	)
);

$resArr =array(
	array(
		'id' => 1,
		'user_name'=>'test1',
		'shop_name'=>'shop1'
	),
	array(
		'id' => 2,
		'user_name'=>'test2',
		'shop_name'=>''
	),
	array(
		'id' => 3,
		'user_name'=>'test3',
		'shop_name'=>'shop3'
	)

);

/**
 * 怎么根据2个数组id相同的一维数组，将$arr2的shop_name添加到$arr，如果没有相同的id，shop_name为空，形成如下数组$resArr
 * todo	跑起来有问题；
 *
 * @link [php将两个数组相同的key合并到一个数组 - SegmentFault 思否](https://segmentfault.com/q/1010000000477066)
 *
 */
function combineArr($arr1, $arr2)
{
	$tempArr = [];

	foreach($arr1 as $k => $v) {
		if(array_key_exists($v['id'], $tempArr)) {
			$arr[$k]['shop_name'] = $tempArr[$v['id']];
		} else {
			$arr[$k]['shop_name'] = '';
		}
	}

	foreach ($arr2 as $item) {
		$tempArr[$item['id']] = $item['shop_name'];
	}

	$resArr = $arr;
	return $resArr;
}

dd(combineArr($arr1, $arr2));
//combineArr($arr1, $arr2);
//var_dump($resArr);
//var_dump(combineArr($arr1, $arr2));