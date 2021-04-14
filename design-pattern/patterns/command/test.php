<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use command\Text;
use command\Console;
use command\OrderSave;
use command\OrderWrite;
use command\OrderCreate;

try {
    // 创建一个记事本实例
    $text = new Text();

    // 创建命令
    $create = new OrderCreate($text, [
    'filename' => 'test.txt',
  ]);
    // 写入命令
    $write = new OrderWrite($text, [
    'filename' => 'test.txt',
    'content' => 'life is a struggle',
  ]);
    // 保存命令
    $save = new OrderSave($text, [
    'filename' => 'text.txt',
  ]);

    // 创建一个控制台
    $console = new Console();
    // 添加命令
    $console->add($create);
    $console->add($write);
    $console->add($save);
    // 运行命令
    $console->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
