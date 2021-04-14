<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use factoryAbstract\PlantFactory;
use factoryAbstract\AnimalFactory;

// 初始化一个动物生产线, 包含了一族产品
$animal = new AnimalFactory();

// 初始化一个植物生产线, 包含了一族产品
$plant = new PlantFactory();

// 模拟调用， 抽象工厂模式核心是面向接口编程
function call(factoryAbstract\Factory $factory)
{
    $earn = function (factoryAbstract\Income $income) {
        $income->money();
    };
    $earn($factory->createFarm());
    $earn($factory->createZoo());
}

call($animal);
call($plant);
