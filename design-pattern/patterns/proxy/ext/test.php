<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use proxy\ext\Proxy;
use proxy\ext\RealSubject;

try {
    echo "未加代理之前：\n";
    $subject = new RealSubject();
    $subject->doSomething();

    echo "\n--------------------\n";

    echo "加代理：\n";
    $proxy = new Proxy($subject);
    $proxy->doSomething();
} catch (\Exception $e) {
    echo $e->getMessage();
}
