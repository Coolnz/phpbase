<?php

require 'simpleDict.php';
require __DIR__ . '/../../vendor/autoload.php';

$sourcePath = './1.txt';
$filteredPath = './2.txt';

// 生成专门的敏感词词库
//SimpleDict::make($sourcePath, $filteredPath);

function search($filteredPath, $text)
{
    $dict = new SimpleDict($filteredPath);
    $result = $dict->search($text);

    return $result;
}

function replace($filteredPath, $text)
{
    $dict = new SimpleDict($filteredPath);
    $replaced = $dict->replace($text, '**');

//    // 高级替换
//    $replaced = $dict->replace('some text here...', function ($word, $value) {
//        return "[$word -> $value]";
    ////        echo "[$word -> $value]";
//    });

    return $replaced;
}

//$text = '呵呵呵呵呵呵哈哈敏感词';
$text = '你好啊';

dd(search($filteredPath, $text));
//dd(replace($filteredPath, $text));
