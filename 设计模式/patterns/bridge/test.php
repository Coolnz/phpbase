<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use bridge\PersonMale;
use bridge\EatByChopsticks;

try {
    // 初始化一个用筷子吃饭的男人的实例
    $male = new PersonMale('male', new EatByChopsticks());
    // 吃饭
    $male->eat('大盘鸡');
} catch (\Exception $e) {
    echo $e->getMessage();
}
