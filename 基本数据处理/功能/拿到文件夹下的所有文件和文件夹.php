<?php

require __DIR__ . '/../../vendor/autoload.php';

//function getK($dirPath)
//{
//    $dir = new RecursiveDirectoryIterator($dirPath);
////    dd($dir);
//    foreach ($dir as $key => $child) {
//        dump($child);
////        dump($child->current()->getFilename());
////        if ($child->valid() && $child->current()->isDir()) {
//        if ($child->valid() && $child->current()->isDir()) {
////            dump($child->getFilename());
//            $childDir[$key] = $child->current()->getFilename();
//        }
//        $child->next();
//    }
////    return $childDir;
//}
//
//function dirScan($dir, $fullpath = false)
//{
//    $ignore = ['.', '..'];
//    if (isset($dir) && is_readable($dir)) {
//        $dlist = [];
//        $dir = realpath($dir);
//        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::KEY_AS_PATHNAME), RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);
//
//        foreach ($objects as $entry) {
//            if (!in_array(basename($entry), $ignore)) {
//                if (!$fullpath) {
//                    $entry = str_replace($dir, '', $entry);
//                }
//                $dlist[] = $entry;
//            }
//        }
//
//        return $dlist;
//    }
//}
//
//function test2($path)
//{
//    $directory_iterator = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::KEY_AS_PATHNAME);
//
//    $files = new RecursiveIteratorIterator($directory_iterator,
//        RecursiveIteratorIterator::SELF_FIRST,
//        RecursiveIteratorIterator::CATCH_GET_CHILD);
//
//    try {
//        foreach ($files as $fullFileName => $file) {
//            $path_parts = pathinfo($fullFileName);
//
//            if (is_file($fullFileName)) {
//                $path_parts = pathinfo($fullFileName);
//                $fileName[] = $path_parts['filename'];
//                $extensionName[] = $path_parts['extension'];
//                $dirName[] = $path_parts['dirname'];
//                $baseName[] = $path_parts['basename'];
//                $fullpath[] = $fullFileName;
//            }
//        }
//
//        foreach ($fullpath as $filles) {
//            echo $filles;
//            echo '</br>';
//        }
//    } catch (UnexpectedValueException $e) {
////        printf("Directory [%s] contained a directory we can not recurse into", $directory);
//        printf('Directory contained a directory we can not recurse into');
//    }
//}
//
//function getDirByIterator($dirPath)
//{
//    $dir = new DirectoryIterator($dirPath);
////    $childDirArr = [];
////    dd($dir->);
//    while ($dir->valid()) {
//        if ($dir->current()->isDir()) {
//            dump($dir->current()->getFilename());
//            echo $dir->current()->getFilename();
//        }
//        $dir->next();
//    }
//}
//
///**
// * 使用foreach循环；.
// *
// * @see [DirectoryIterator遍历目录下的所有文件 - php开发者 - SegmentFault 思否](https://segmentfault.com/a/1190000010857391)
// *
// * todo 只能拿到文件名，拿不到文件夹；
// *
// * @param $dirPath
// */
//function getDocByIteratorForeach($dirPath)
//{
//    //遍历目录下的所有文件
//    $dir = new DirectoryIterator($dirPath);
//
//    //todo $dir是一个对象，foreach能遍历对象，array_map()不能遍历对象；
//    foreach ($dir as $file) {
//        //获取文件名称；
//        if ($file->isFile()) {
//            return $file->getFilename() . '<br />';
//        }
//    }
//}
//
///**
// * 使用while循环获取；.
// *
// * @param $dirPath
// */
//function getDocByIteratorWhile($dirPath)
//{
//    //遍历目录下的所有文件
//    $dir = new DirectoryIterator($dirPath);
//    //2、while循环
//    while ($dir->valid()) {
//        if ($dir->current()->isFile()) {
//            echo $dir->current()->getFilename() . '<br />';
//        }
//        $dir->next();
//    }
//}

/**
 * scandir()+递归；.
 *
 * @param $dirPath
 */
function getDocByScanDir($dirPath)
{
    $arr = scandir($dirPath);
    foreach ($arr as $key => $val) {
        if ('.' != $val && '..' != $val) {
            $path = $dirPath . '/' . $val;
            if (is_dir($path)) {
                getDocByScanDir($path);
            } else {
                echo "<p>{$path}</p>";
            }
        }
    }
}




function getDocByReadDir2($path)
{
    $handle = opendir($path); //打开目录返回句柄

    $outputDir = [];
    while (false !== ($content = readdir($handle))) {
        $new_dir = $path . DIRECTORY_SEPARATOR . $content;

        if ('..' == $content || '.' == $content) {
            continue;
        }
        if (is_dir($new_dir)) {
            $outputDir[] = $new_dir;
            getDocByReadDir2($new_dir);
        }
    }

    return $outputDir;
}

function getDocByReadDir3($dir)
{
    $i = 1;
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if ('.' != $file && '..' != $file) {
                if (true == is_dir($dir . '/' . $file)) {
                    $fullpath = $dir . '/' . $file;
                    getDocByReadDir3($fullpath);
                    echo "$fullpath\n";
                    ++$i;
                } else {
                    $fullpath = $dir . '/' . $file;
                    echo "$fullpath\n";

                    ++$i;
                }
            }
        }
        closedir($handle);
    }
}
//get_dir_info($dir);



/**
 * @param $path
 * @param $files
 */
//function getAllFiles($path, &$files)
//{
//    if (is_dir($path)) {
//        $dp = dir($path);
//        while ($file = $dp->read()) {
//            //去掉所有文件名为.或者..的情况；
//            if ('.' != $file && '..' != $file) {
//                //				var_dump($file);
//                //				var_dump(getSuffix($file));
//                //去掉所有后缀不是doc或者docx的文件
//                //				var_dump(removeSuffixExceptDoc($file));
//                //				$targetFile = removeSuffixExceptDoc($file) ? ;
//                //				var_dump($targetFile);
//                getAllFiles($path . '/' . $file, $files);
//            }
//        }
//        $dp->close();
//    }
//
//    if (is_file($path)) {
//        $files[] = $path;
//    }
//}

///**
// * 拿到文件夹下的文件，并返回一个数组；.
// *
// * @param $dir
// *
// * @return array
// */
//function getFilenameByDir($dir)
//{
//    $files = [];
//    getAllFiles($dir, $files);
//
//    return $files;
//}

$dirPath = '/Users/luruiyang/Documents/github';

// 获取该文件夹下的文件夹
//dump(getDocByReadDir2($dirPath));

// 获取该文件夹下的所有文件
//dump(getDocByScanDir($dirPath));


/**
 * 递归+dir().
 *
 * @param $dirPath
 */
function getDocByDir($dirPath)
{
    $mydir = dir($dirPath);
    echo "<ul>\n";
    while ($file = $mydir->read()) {
        if ((is_dir("$dirPath/$file")) and ('.' != $file) and ('..' != $file)) {
//            echo "<li><font color=\"#ff00cc\"><b>$file</b></font></li>\n";
            echo "<li>$file</li>\n";
            getDocByDir("$dirPath/$file");
        } else {
            echo "<li>$file</li>\n";
        }
    }
    echo "</ul>\n";
    $mydir->close();
}

/**
 * 用opendir()+readdir()函数+递归；
 *  * 确定是文件夹 ——
 * 打开文件夹(产生dh句柄) ——
 * 循环读取文件夹内容(读取句柄的内容，即为file/folder) ——
 * 递归读取上一步判断为folder且文件夹不为'.'或者'..'的文件夹内容.
 *
 * @see [PHP写一个函数，能够遍历一个文件夹下的所有文件和子文件夹。 - CSDN博客](https://blog.csdn.net/wuhuagu_wuhuaguo/article/details/56699372)
 *
 * todo 这个只是展示出来，没有转成数组；
 *
 * @param $dirPath
 */
function getDocByReadDir1($dirPath)
{
    $dir = opendir($dirPath);
    echo '<ul>';
    while ($f = readdir($dir)) {
        if ('.' != $f && '..' != $f) {
            echo "<li>{$f}</li>";
            if (is_dir("$dirPath/{$f}")) {
                getDocByReadDir1("$dirPath/{$f}");
            }
        }
    }
    echo '</ul>';
}

//function nw($dirPath)
//{
//    $dir = opendir($dirPath);
//    $dir = [];
//    while ($f = readdir($dir)) {
//        if ('.' != $f && '..' != $f) {
////            echo "<li>{$f}</li>";
//            echo "<li>{$f}</li>";
//            if (is_dir("$dirPath/{$f}")) {
//                nw("$dirPath/{$f}");
//            }
//        }
//    }
//    echo '</ul>';
//}
// 输出结构化的文件夹
dump(getDocByReadDir1($dirPath));
// 类似，但是文件夹加了颜色
//dump(getDocByDir($dirPath));


// 获取该文件夹下所有文件的绝对路径
//dump(getDocByReadDir3($dirPath));




