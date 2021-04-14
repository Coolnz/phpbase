<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use mediator\Tenant;
use mediator\Landlord;
use mediator\HouseMediator;

try {
    // 初始化一个租客
    $tenant = new Tenant('小明');

    // 小明直接找小梅租房
    $landlord = new Landlord('小梅');
    echo $landlord->doSomthing($tenant);

    // 小明通过房屋中介租房
    // 初始化一个房屋中介
    $mediator = new HouseMediator();
    // 租房
    $mediator->rentHouse($tenant);
} catch (\Exception $e) {
    echo 'error:' . $e->getMessage();
}
