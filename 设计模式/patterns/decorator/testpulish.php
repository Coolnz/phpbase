<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

use decorator\BasicPulisher;
use decorator\MoviePulisher;
use decorator\MusicPublisher;

try {
    $basicPulisher = new BasicPulisher();
    $moviePulisher = new MoviePulisher();
    $musicPulisher = new MusicPublisher();

    $moviePulisher->derect($basicPulisher);
    $musicPulisher->derect($moviePulisher);
    $musicPulisher->pulishText();
} catch (\Exception $e) {
    echo $e->getMessage();
}
