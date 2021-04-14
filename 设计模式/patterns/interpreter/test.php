<?php

// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use interpreter\SqlInterpreter;

try {
    //增加数据
    SqlInterpreter::db('user')->insert([
    'nickname' => 'tigerb',
    'mobile' => '1366666666',
    'password' => '123456',
  ]);
    //删除数据
    SqlInterpreter::db('user')->delete([
    'nickname' => 'tigerb',
    'mobile' => '1366666666',
  ]);
    //修改数据
    SqlInterpreter::db('member')->update([
    'id' => '1',
    'nickname' => 'tigerbcode',
  ]);
    //查询数据
    SqlInterpreter::db('member')->find([
    'mobile' => '1366666666',
  ]);
} catch (\Exception $e) {
    echo 'error:' . $e->getMessage();
}
