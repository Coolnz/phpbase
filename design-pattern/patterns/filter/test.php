<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use filter\FilterGender;
use filter\SportsPerson;
use filter\FilterSportType;

try {
    // 定义一组运动员
    $persons = [];
    $persons[] = new SportsPerson('male', 'basketball');
    $persons[] = new SportsPerson('female', 'basketball');
    $persons[] = new SportsPerson('male', 'football');
    $persons[] = new SportsPerson('female', 'football');
    $persons[] = new SportsPerson('male', 'swim');
    $persons[] = new SportsPerson('female', 'swim');

    // 按过滤男性
    $filterGender = new FilterGender('male');
    var_dump($filterGender->filter($persons));
    // 过滤运动项目篮球
    $filterSportType = new FilterSportType('basketball');
    var_dump($filterSportType->filter($persons));
} catch (\Exception $e) {
    echo $e->getMessage();
}
