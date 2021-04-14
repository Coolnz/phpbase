<?php

require __DIR__ . 'geo.php';

$geohash = new GeoHash();
$latitude = 31.224349;
$longitude = 121.476753;
$hash = $geohash->encode($latitude, $longitude);
//var_dump($hash);exit;
//决定查询范围，值越大，获取的范围越小
//当geohash base32编码长度为8时，精度在19米左右，而当编码长度为9时，精度在2米左右，编码长度需要根据数据情况进行选择。
$pre_hash = mb_substr($hash, 0, 5);
//取出相邻八个区域
$neighbors = $geohash->neighbors($pre_hash);
array_push($neighbors, $pre_hash);

$values = '';
foreach ($neighbors as $key => $val) {
    $values .= '\'' . $val . '\'' . ',';
}
$values = mb_substr($values, 0, -1);
// var_dump($values);
$stores = \DB::select("SELECT * FROM `stores` WHERE LEFT(`geohash`,5) IN ($values)");

foreach ($stores as $key => $value) {
    $geohash_arr = $geohash->decode($value->geohash);
    $stores[$key]->latitude = $geohash_arr[0]; //纬度
    $stores[$key]->longitude = $geohash_arr[1]; //经度
    $distance = $this->getDistance($request['latitude'], $request['longitude'], $value->latitude, $value->longitude);
    $stores[$key]->distance = $distance;
    $sortdistance[$key] = $distance;
}
array_multisort($sortdistance, SORT_ASC, $stores);
// var_dump($stores);
return response()->json(['status_code' => 0, 'nearby_stores' => $stores]);
