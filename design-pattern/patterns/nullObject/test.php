<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use nullObject\Student;
use nullObject\Teacher;

try {
    //创建一个老师：路飞
    $teacher = new Teacher('路飞');

    // 创建学生
    $mc = new Student('麦迪');
    $kobe = new Student('科比');
    $paul = new Student('保罗');

    // 老师提问
    $teacher->doSomthing($mc);
    $teacher->doSomthing($kobe);
    $teacher->doSomthing($paul);
    $teacher->doSomthing('小李'); // 提问了一个班级里不存在人名
} catch (\Exception $e) {
    echo 'error:' . $e->getMessage();
}
