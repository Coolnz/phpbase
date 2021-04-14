<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use template\SmsCompanyOne;
use template\SmsCompanyTwo;

try {
    // 用厂商one发短信
    $one = new SmsCompanyOne([
    'appkey' => 'akjlooolllnn',
  ]);
    $one->send('13666666666');

    // 用厂商two发短息
    $one = new SmsCompanyTwo([
    'pwd' => 'adadeooonn',
  ]);
    $one->send('13666666666');
} catch (\Exception $e) {
    echo 'error:' . $e->getMessage();
}
