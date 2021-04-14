<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-13
 * Time: 23:28
 */


/**
 * @link https://blog.csdn.net/fdipzone/article/details/78070334
 *
 * 将多个一维数组合拼成二维数组（使用的时候，注意$key的使用；）
 *
 * @param  Array $keys 定义新二维数组的键值，每个对应一个一维数组
 * @param  Array $args 多个一维数组集合
 * @return Array
 */
function array_merge_more($keys, ...$arrs){

	// 检查参数是否正确
	if(!$keys || !is_array($keys) || !$arrs || !is_array($arrs) || count($keys)!=count($arrs)){
		return array();
	}

	// 一维数组中最大长度
	$max_len = 0;

	// 整理数据，把所有一维数组转重新索引
	for($i=0,$len=count($arrs); $i<$len; $i++){
		$arrs[$i] = array_values($arrs[$i]);

		if(count($arrs[$i])>$max_len){
			$max_len = count($arrs[$i]);
		}
	}

	// 合拼数据
	$result = array();

	for($i=0; $i<$max_len; $i++){
		$tmp = array();
		foreach($keys as $k=>$v){
			if(isset($arrs[$k][$i])){
				$tmp[$v] = $arrs[$k][$i];
			}
		}
		$result[] = $tmp;
	}

	return $result;

}

$arr1 = array('fdipzone', 'terry', 'alex');
$arr2 = array(18, 19, 20);
$arr3 = array('programmer', 'designer', 'tester');

$keys = array('name','age','profession');

$result = array_merge_more($keys, $arr1, $arr2, $arr3);

print_r($result);
