<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use flyweight\Farm;

// 初始化一个工厂
$farm = new Farm();

// 成产一只鸡
$farm->produce('chicken')->getType();
// 再生产一只鸡
$farm->produce('chicken')->getType();
