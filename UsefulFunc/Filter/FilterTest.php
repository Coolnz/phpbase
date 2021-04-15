<?php

namespace UsefulFunc\Filter;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class FilterTest extends TestCase
{
    public function test1()
    {
        $sourcePath = './1.txt';
        $filteredPath = './2.txt';

        $text = '你好啊';
//        SimpleDict::make($sourcePath, $filteredPath);
        dd($this->search($filteredPath, $text));
    }

    public function search($filteredPath, $text)
    {
        $dict = new SimpleDict($filteredPath);
        $result = $dict->search($text);

        return $result;
    }

    public function replace($filteredPath, $text)
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
}
