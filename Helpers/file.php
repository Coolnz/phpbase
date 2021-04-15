<?php

/**
 * 用curl抓图片；会乱码；.
 * 用file_put_contents；只能在知道文件在项目里的路径的情况下，才能使用这个方法；
 * 需要用这个方法；.
 */
function getFileByUrl(string $url)
{
    //$des文件夹是目标文件夹的地址；
    $destination_folder = __DIR__ . '/images/';
    //存到本地文件名
    $newfname = $destination_folder . 'silicon valley-' . mt_rand(1, 33) . '.jpg'; //set your file ext
    $file = fopen($url, 'rb');

    if ($file) {
        $newf = fopen($newfname, 'a'); // to overwrite existing file
        if ($newf) {
            while (!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }
    }
    if ($file) {
        fclose($file);
    }
    if ($newf) {
        fclose($newf);
    }
}

/**
 * PHP读取Word文档；.
 *
 * @url https://stackoverflow.com/questions/10646445/read-word-document-in-php   ；并不需要PHPWORD，用这个方法可以直接取出字符串；
 *
 * @param $filename
 *
 * @return bool|string
 */
function getDocDetail($filename = '')
{
    $striped_content = '';
    $content = '';

    if (!$filename || !file_exists($filename)) {
        return false;
    }

    $zip = zip_open($filename);
    if (!$zip || is_numeric($zip)) {
        return false;
    }

    while ($zip_entry = zip_read($zip)) {
        if (false == zip_entry_open($zip, $zip_entry)) {
            continue;
        }
        if ('word/document.xml' != zip_entry_name($zip_entry)) {
            continue;
        }
        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
        zip_entry_close($zip_entry);
    }
    zip_close($zip);
    $content = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return $striped_content;
}

/**
 * a相对于b的路径计算方法？计算两个文件的相对路径.
 *
 * @param $a
 * @param $b
 */
function getPath($a, $b)
{
    $aarr = explode('/', $a);
    $barr = explode('/', $b);
    $count = count($barr) - 2;
    $pathinfo = '';
    for ($i = 1; $i <= $count; ++$i) {
        if ($aarr[$i] == $barr[$i]) {
            $pathinfo .= '../';
        } else {
            $pathinfo .= $barr[$i] . '/';
        }
    }

    return $pathinfo;
}

//写一个函数，算出两个文件的相对路径
//如 $a = '/a/b/c/d/e.php';
//$b = '/a/b/12/34/c.php';
//计算出 $b 相对于 $a 的相对路径应该是 ../../c/d将()添上
function getRelativePath($a, $b)
{
    $returnPath = [dirname($b)];
    $arrA = explode('/', $a);
    $arrB = explode('/', $returnPath[0]);
    for ($n = 1, $len = count($arrB); $n < $len; ++$n) {
        if ($arrA[$n] != $arrB[$n]) {
            break;
        }
    }
    if ($len - $n > 0) {
        $returnPath = array_merge($returnPath, array_fill(1, $len - $n, '..'));
    }

    $returnPath = array_merge($returnPath, array_slice($arrA, $n));

    return implode('/', $returnPath);
}

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
                echo "$path\n";
            }
        }
    }
}

// 只有一层深度
function getDocByReadDir2($path): array
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
