<?php

require __DIR__ . '/../../vendor/autoload.php';

function getNearPerson($lng, $lat, $distance)
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

dd(getNearPerson(31.224349, 121.476753, 10));
