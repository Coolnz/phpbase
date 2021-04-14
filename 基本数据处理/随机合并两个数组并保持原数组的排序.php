<?php

require __DIR__ . '/../vendor/autoload.php';

//[[算法]PHP随机合并数组并保持原排序 - 韭白 - 博客园](https://www.cnblogs.com/shockerli/p/shuffle-merge-array.html)

function shuffleMergeArray($array1, $array2) {
	$mergeArray = [];
	$sum = count($array1) + count($array2);
	for ($k = $sum; $k > 0; $k--) {
		$number = mt_rand(1, 2);
		if ($number == 1) {
			$mergeArray[] = $array2 ? array_shift($array2) : array_shift($array1);
		} else {
			$mergeArray[] = $array1 ? array_shift($array1) : array_shift($array2);
		}
	}

	return $mergeArray;
}

$array1 = array(1, 2, 3, 4);
$array2 = array('a', 'b', 'c', 'd', 'e');

$res = shuffleMergeArray($array1, $array2);

$res2 = shuffleMergeArray($array2, $array1);

//dd($res);

dd($res2);