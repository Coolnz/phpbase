<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-15
 * Time: 09:34
 */

class Map
{
	public function map1($array)
	{
		//使用“&”取址符就可以赋值闭包外的变量了。
		$res = [];
		return array_map(function($item) use (&$res){
			$res[$item['sku_id']] = $item['sku_amount'];
		}, $array);
	}

	public function map2($list)
	{
		$res = array_map('floatval', $list);
		return $res;
	}

	/**
	 * @param $key
	 * @param $array
	 * @return array
	 */
	public function map3($key, $array)
	{
		$ar = array_map ( function ($element) use($key) {
			$newArray = [];
			if (array_key_exists ( $key, $element )) {
				$newArray = $element [$key];
			}
			return $newArray;
		}, $array );

		return $ar;
	}


	/**
	 * foreach转化为array_map()
	 *
	 * @param $arr
	 * @return bool|string
	 */
	function arr2str ($arr)
	{
//	foreach ($arr as $v) {
//		//一维数组转字符串
//		$v = implode(",",$v);
//		$temp[] = $v;
//	}
//	var_dump($temp);
		$temp = array_map(function($value){
			return implode(",", $value);
		}, $arr);
//	var_dump($temp);


		$t="";
//	foreach ($temp as $v) {
//		$t.="'".$v."'".",";
//	}
		array_map(function($v) use (&$t){
			$t.="'".$v."'".",";
		}, $temp);
		$t=substr($t,0,-1);
		return $t;
	}


}

$array = [
	0=>['sku_id'=>'11','sku_amount'=>240],
	1=>['sku_id'=>'27','sku_amount'=>600]
];
$list = [3, 4, 5, 6, 7, 9];
$key = 'id';
$array = array (
	array (
		"id" => 12,
		"name" => "Karl"
	),
	array (
		"id" => 4,
		"name" => "Franz"
	),
	array (
		"id" => 9,
		"name" => "Helmut"
	),
	array (
		"id" => 10,
		"name" => "Kurt"
	)
);

$map = new Map();
var_dump($map->map2($list));


class Reduce
{
	/**
	 * @param $list
	 * @return mixed
	 */
	public function reduce1($list)
	{
		$sum = array_reduce($list, function($result, $v){
			return $result + $v;
		});

		return $sum;
	}

	public function reduce2($arr)
	{
		return array_reduce($arr, function($result, $v){
			return $result.','.$v['id'];
		});
	}
}
$arr = array(
	array("id"=>1,'name'=>"a"),
	array("id"=>2,"name"=>"c"),
	array("id"=>3,"name"=>"d")
);


class Filter
{
	/**
	 * 把$arr as $key => $val的改写成array_filter()；
	 * 不需要管$key；直接操作$val的值就可以了；
	 * @param $arr
	 * @return array
	 */
	public function filter1($arr)
	{
//		foreach($arr as $k => $v) {
//			if($v > 1) {
//				$tmp[$k] = $v;
//			}
//		}
//
//		return $tmp;

		return array_filter($arr, function($v){
			return $v > 1;
		});
	}
}
$arr = [1, 2, 3];
$filter = new Filter();
var_dump($filter->filter1($arr));

