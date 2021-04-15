<?php

namespace Helpers\File;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class FileTest extends TestCase
{
    private $dirPath = '/Users/luruiyang/Documents/zipkin';

    public function testGetPath()
    {
        $a = 'a/b/c/d/e.php';
        $b = 'a/b/12/34/56.php';

        $res = getPath($a, $b);
        $ret = '../12/34/';

        $this->assertEquals($ret, $res);
    }

    public function testGetRelativePath()
    {
        $a = 'a/b/c/d/e.php';
        $b = 'a/b/12/34/56.php';

        $res = getRelativePath($a, $b);
        $ret = 'a/b/12/34/../../c/d/e.php';

        dump($res);
        $this->assertEquals($ret, $res);
    }

    public function testGetDocByScanDir()
    {
//        getDocByScanDir($this->dirPath);

//        $res = getDocByReadDir2($this->dirPath);
//        dd($res);

//        getDocByReadDir3($this->dirPath);

//        getDocByDir($this->dirPath);

//        getDocByReadDir1($this->dirPath);
    }
}
