<?php

/**
 * @desc 根据两点间的经纬度计算距离
 *
 * @param float $latitude  纬度值
 * @param float $longitude 经度值
 */
function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
{
    $earth_radius = 6371000; //approximate radius of earth in meters

    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;

    return round($d); //四舍五入
}

$latitude1 = '121.476753';
$longitude1 = '31.224349';
$latitude2 = '121.24';
$longitude2 = '31.4';
$as = getDistance($latitude1, $longitude1, $latitude2, $longitude2);
var_dump($as); exit;
