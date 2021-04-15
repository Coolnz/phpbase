<?php

namespace UsefulFunc\Nearby;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class GeoTest extends TestCase
{
    public function test1()
    {
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
//            $distance = $this->getDistance($request['latitude'], $request['longitude'], $value->latitude, $value->longitude);
//            $distance = $this->getDistance($request['latitude'], $request['longitude'], $value->latitude, $value->longitude);
            $stores[$key]->distance = $distance;
            $sortdistance[$key] = $distance;
        }
        array_multisort($sortdistance, SORT_ASC, $stores);
        // var_dump($stores);
        return response()->json(['status_code' => 0, 'nearby_stores' => $stores]);
    }

    public function test2()
    {
        $latitude1 = '121.476753';
        $longitude1 = '31.224349';
        $latitude2 = '121.24';
        $longitude2 = '31.4';
        $as = $this->getDistance($latitude1, $longitude1, $latitude2, $longitude2);
        var_dump($as);
        exit;
    }

    public function test3()
    {
        dd($this->getNearPerson(31.224349, 121.476753, 10));
    }

    public function test4()
    {
        $geohash = new Geohash();
        //得到这点的hash值
        $hash = $geohash->encode(39.98123848, 116.30683690);
        //取前缀，前缀约长范围越小
        $prefix = mb_substr($hash, 0, 6);
        //取出相邻八个区域
        $neighbors = $geohash->neighbors($prefix);
        array_push($neighbors, $prefix);

        print_r($neighbors);
    }

    /**
     * @desc 根据两点间的经纬度计算距离
     *
     * @param float $latitude  纬度值
     * @param float $longitude 经度值
     */
    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371000; //approximate radius of earth in meters

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return round($d); //四舍五入
    }

    public function getNearPerson($lng, $lat, $distance)
    {
        define('EARTH_RADIUS', 6371); //地球半径
        $dLng = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
        $dLng = rad2deg($dLng);
        $dLat = $distance / EARTH_RADIUS;
        $dLat = rad2deg($dLat);

        $squares = [
            'left-top' => ['lat' => $lat + $dLat, 'lng' => $lng - $dLng],
            'right-top' => ['lat' => $lat + $dLat, 'lng' => $lng + $dLng],
            'left-bottom' => ['lat' => $lat - $dLat, 'lng' => $lng - $dLng],
            'right-bottom' => ['lat' => $lat - $dLat, 'lng' => $lng + $dLng],
        ];

        return $squares;
    }
}
