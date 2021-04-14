<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use factory\Zoo;
use factory\Farm;
use factory\SampleFactory;

// 初始化一个工厂
$farm = new Farm();

// 生产一只鸡
$farm->produce('chicken');
// 生产一只猪
$farm->produce('pig');

// 初始化一个动物园工厂
$zoo = new Zoo();
$zoo->produce('chicken');
$zoo->produce('pig');

// 工厂方法模式退化为简单工厂模式
SampleFactory::produce('chicken');
SampleFactory::produce('pig');
