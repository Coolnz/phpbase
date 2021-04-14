<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-13
 * Time: 23:19
 */


/**
 * [求教一个PHP二维数组转一维数组最有效率的方法 - SegmentFault 思否](https://segmentfault.com/q/1010000004087076)
 *
 * [PHP将二维数组转为一维数组_百度经验](https://jingyan.baidu.com/article/1974b289a233d6f4b1f77431.html)
 */


/**
 * 用array_map()实现二维转一维；
 *
 * array_map
 */
function mapFlatten($items)
{

	$result = [];
	array_map(function($value) use (&$result) {
		$result = array_merge($result, array_values($value));
	}, $items);

	return $result;
}

print_r(mapFlatten($items));


/**
 * 用array_reduce()实现二维转一维；
 *
 * array_merge把相同字符串键名的数组覆盖合并，所以必须先用array_value取出值后，再合并；
 *
 * @param $items
 * @return mixed
 */
function reduceFlatten($items)
{
	$result = array_reduce($items, function($result, $value) {
		return array_merge($result, array_values($value));
	}, []);

	return $result;
}


print_r(reduceFlatten($items));


/**
 * 用array_walk()也实现一个二维转一维吧；
 *
 */


/**
 * 用foreach()一样可以；其实跟上面几个数组回调方法一样；都是起到循环的作用；
 *
 * 二维数组转一维数组；
 *
 * @param $items
 * @return array
 */
function flatten($items)
{

	$result = [];
	foreach ($items as $item) {
		if (!is_array($item)) {
			$result[] = $item;
		} else {
			$result = array_merge($result, array_values($item));
		}
	}
	return $result;
}

print_r(flatten($items));


