<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use builder\ProductBuilder;

$builder = new ProductBuilder();

// 生产一款mp3
$builder->getMp3([
  'name' => '某族MP3',
  'hardware' => [
    'cpu' => 1,
    'ram' => 1,
    'storage' => 128,
  ],
  'software' => ['os' => 'mp3 os'],
]);

echo "\n";
echo "----------------\n";
echo "\n";

// 生产一款手机
$builder->getPhone([
  'name' => '某米8s',
  'hardware' => [
    'screen' => '5.8',
    'camera' => '2600w',
    'cpu' => 4,
    'ram' => 8,
    'storage' => 128,
  ],
  'software' => ['os' => 'android 6.0'],
]);
