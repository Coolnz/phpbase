<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use facade\AnimalMaker;

// 初始化外观类
$animalMaker = new AnimalMaker();

// 生产一只猪
$animalMaker->producePig();

// 生产一只鸡
$animalMaker->produceChicken();
