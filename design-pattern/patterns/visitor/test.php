<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use visitor\Person;
use visitor\VisitorAsia;
use visitor\VisitorAmerica;

// 生产一个人的实例
$person = new Person();

// 来到了亚洲
$person->eat(new VisitorAsia());

// 来到了美洲
$person->eat(new VisitorAmerica());
