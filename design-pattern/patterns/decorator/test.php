<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use decorator\ShoesSport;
use decorator\DecoratorBrand;

try {
    echo "未加装饰器之前：\n";
    // 生产运动鞋
    $shoesSport = new ShoesSport();
    $shoesSport->product();

    echo "\n--------------------\n";
    //-----------------------------------

    echo "加贴标装饰器：\n";
    // 初始化一个贴商标适配器
    $DecoratorBrand = new DecoratorBrand(new ShoesSport());
    $DecoratorBrand->_brand = 'nike';
    // 生产nike牌运动鞋
    $DecoratorBrand->product();
} catch (\Exception $e) {
    echo $e->getMessage();
}
