<?php

/**
 * 使用fgetc逐字读取；来降低内存使用；.
 */
function readByBite($file)
{
    $fp = fopen($file, 'r');
    while (false !== ($ch = fgetc($fp))) {
        // ⚠️⚠️⚠️ 作为测试代码是否正确，你可以打开注释 ⚠️⚠️⚠️
        // 但是，打开注释后屏显字符会严重拖慢程序速度！也就是说程序运行速度可能远远超出屏幕显示速度
//	echo $char.PHP_EOL;
    }
    fclose($fp);
}

/**
 * 每次读写一行；
 * 花费时间：0.61566114425659 sec.
 */
function readByLine($file)
{
    $fp = fopen($file, 'r');
    while (false !== ($buffer = fgets($fp, 4096))) {
        //echo $buffer.PHP_EOL;
    }
    if (!feof($fp)) {
        throw new Exception('... ...');
    }
    fclose($fp);
}

/**
 * 每次读取固定大小的文件；
 * 花费时间：0.11307597160339 sec.
 */
function readBySize($file)
{
    $fp = fopen($file, 'r');
    while (!feof($fp)) {
        // 如果你要使用echo，那么，你会很惨烈...
        fread($fp, 10240);
    }
    fclose($fp);
}

/**
 * 通过stream_get_line()流函数进行读取；
 * 花费时间：3.9151079654694 sec.
 *
 * @url https://www.jb51.net/article/81909.htm
 */
function readByStream($file)
{
    $fp = fopen($file, 'r');
    while (!feof($fp)) {
        stream_get_line($fp, 65535, 'n');
    }
}

/**
 * yield+fgets；.
 *
 * 花费时间：0.00054597854614258 sec
 */
function readByYield($file)
{
    $fp = fopen($file, 'r');
    try {
        while ($line = fgets($fp)) {
            yield $line;
        }
    } finally {
        fclose($fp);
    }
}

/**
 * yield+fread每次读取部分字节，来降低内存使用；.
 *
 * @param $file
 *
 * @return Generator
 */
function readByYield2($file)
{
    $fp = fopen($file, 'rb');
    while (false === feof($fp)) {
        //每次只读取1024个字节；
        yield fread($fp, 1024);
    }
    fclose($file);
}

/**
 * 使用SplFileObj类写入；.
 *
 * 写入完成后，生成的文件167M；
 * 花费时间：2.1238491535187 sec
 *
 * @url https://blog.csdn.net/AIkiller/article/details/78925015
 * @url http://php.net/manual/zh/class.splfileobject.php
 *
 * @param $file
 */
function writeBySplFileObj($file)
{
    $str = '';
    for ($a = 0; $a < 50; ++$a) {
        $str .= 'abc, ccc, ddd,';
    }
    $str = trim($str, ',');
    $str .= "\r\n";

    for ($i = 0; $i < 100; ++$i) {
        $example = new SplFileObject($file, 'a');

        for ($j = 0; $j < 2500; ++$j) {
            $example->fwrite($str);
        }
        $example->fflush();
    }
}

function getTime()
{
    $begin = microtime(true);

    $file = 'test.log';
    $newFile = 'test1.log';
    //	readBySize($file);
    //	readByLine($file);
    //	readByStream($file);
    //	readByYield($file);
    //	readByYield2($file);

    //	writeToLog($file, $newFile);
    writeBySplFileObj($newFile);
    $end = microtime(true);
    echo '花费时间：' . ($end - $begin) . ' sec' . PHP_EOL;
}

/**
 * 读取之后直接写入新文件；
 * 花费时间：15.563895940781 sec.
 *
 * @param $file
 * @param $newFile
 */
function writeToLog($file, $newFile)
{
    foreach (readByYield2($file) as $n => $line) {
        file_put_contents($newFile, $line, FILE_APPEND);
    }
}

getTime();
