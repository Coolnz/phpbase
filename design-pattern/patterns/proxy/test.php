<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use proxy\Proxy;
use proxy\ShoesSport;

try {
    echo "未加代理之前：\n";
    // 生产运动鞋
    $shoesSport = new ShoesSport();
    $shoesSport->product();

    echo "\n--------------------\n";
    //-----------------------------------

    echo "加代理：\n";
    // 把运动鞋产品线外包给代工厂
    $proxy = new Proxy('sport');
    // 代工厂生产运动鞋
    $proxy->product();
} catch (\Exception $e) {
    echo $e->getMessage();
}
