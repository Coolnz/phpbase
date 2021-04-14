<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test 实现一个文件夹

use composite\File;
use composite\Folder;

try {
    // 构建一个根目录
    $root = new Folder('根目录');

    // 根目录下添加一个test.php的文件和usr,mnt的文件夹
    $testFile = new File('test.php');
    $usr = new Folder('usr');
    $mnt = new Folder('mnt');
    $root->add($testFile);
    $root->add($usr);
    $root->add($mnt);
    $usr->add($testFile); // usr目录下加一个test.php的文件

    // 打印根目录文件夹节点
    $root->printComposite();
} catch (\Exception $e) {
    echo $e->getMessage();
}
