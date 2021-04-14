<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-13
 * Time: 23:36
 */
$infos = array(
	array(
		'a' => 36,
		'b' => 'xa',
		'c' => '2015-08-28 00:00:00',
		'd' => '2015/08/438488a00b3219929282e3652061c2e3.png'
	),
	array(
		'a' => 3,
		'b' => 'vd',
		'c' => '2015-08-20 00:00:00',
		'd' => '2015/08/438488a00b3219929282e3652061c2e3.png'
	),
	array(
		'a' => 6,
		'b' => 'wwe',
		'c' => '2015-08-28 00:00:00',
		'd' => '2015/08/438488a00b3219929282e3652061c2e3.png'
	),
	array(
		'a' => 36,
		'b' => 'se',
		'c' => '2015-08-28 00:00:00',
		'd' => '2015/08/438488a00b3219929282e3652061c2e3.png'
	),
	array(
		'a' => 6,
		'b' => 'aw',
		'c' => '2015-08-28 00:00:00',
		'd' => '2015/08/438488a00b3219929282e3652061c2e3.png'
	),
	array(
		'a' => 36,
		'b' => 'bv',
		'c' => '2015-08-28 00:00:00',
		'd' => '2015/08/438488a00b3219929282e3652061c2e3.png'
	),
	array(
		'a' => 12,
		'b' => 'xx',
		'c' => '2015-08-27 00:00:00',
		'd' => '2015/08/438488a00b3219929282e3652061c2e3.png'
	)
);


function combineSameKey($array, $combineKey)
{
	$result = [];
	foreach ($array as $key => $info) {
		$result[$info[$combineKey]][] = $info;
	}
	return $result;
}

var_dump(combineSameKey($infos, 'a'));die;
