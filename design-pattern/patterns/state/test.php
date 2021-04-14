<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use state\Farmer;

try {
    // 初始化一个农民
    $farmer = new Farmer();

    // 春季
    $farmer->grow();
    $farmer->harvest();
    // 夏季
    $farmer->grow();
    $farmer->harvest();
    // 秋季
    $farmer->grow();
    $farmer->harvest();
    // 冬季
    $farmer->grow();
    $farmer->harvest();
} catch (\Exception $e) {
    echo 'error:' . $e->getMessage();
}
