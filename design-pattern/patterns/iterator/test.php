<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use iterator\SchoolExperimental;

try {
    // 初始化一个实验小学
    $experimental = new SchoolExperimental();
    // 添加老师
    $experimental->addTeacher('Griffin');
    $experimental->addTeacher('Curry');
    $experimental->addTeacher('Mc');
    $experimental->addTeacher('Kobe');
    $experimental->addTeacher('Rose');
    $experimental->addTeacher('Kd');
    // 获取教师迭代器
    $iterator = $experimental->getIterator();
    // 打印所有老师
    do {
        $iterator->current();
    } while ($iterator->hasNext());
} catch (\Exception $e) {
    echo 'error:' . $e->getMessage();
}
