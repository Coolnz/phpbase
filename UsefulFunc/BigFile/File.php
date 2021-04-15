<?php

namespace UsefulFunc\BigFile;

use Exception;

class File
{
    public function readFile1($file)
    {
        $fp = fopen($file, 'r');
        $line = 10;
        $pos = -2;
        $t = ' ';
        $data = '';
        while ($line > 0) {
            while ("\n" != $t) {
                fseek($fp, $pos, SEEK_END);
                $t = fgetc($fp);
                --$pos;
            }
            $t = ' ';
            $data .= fgets($fp);
            --$line;
        }
        fclose($fp);
    }

    //echo $data;

    public function readFile2($file)
    {
        $fp = fopen($file, 'r');
        $num = 10;
        $chunk = 4096;
        $fs = sprintf('%u', filesize($file));
        $max = (PHP_INT_MAX == intval($fs)) ? PHP_INT_MAX : filesize($file);
        for ($len = 0; $len < $max; $len += $chunk) {
            $seekSize = ($max - $len > $chunk) ? $chunk : $max - $len;
            fseek($fp, ($len + $seekSize) * -1, SEEK_END);
//            $readData = fread($fp, $seekSize) . $readData;
            $readData = fread($fp, $seekSize);

            if (mb_substr_count($readData, "\n") >= $num + 1) {
                preg_match("!(.*?\n){" . ($num) . '}$!', $readData, $match);
                $data = $match[0];
                break;
            }
        }
        fclose($fp);
        echo $data;
    }

    public function tail($fp, $n, $base = 5)
    {
        assert($n > 0);
        $pos = $n + 1;
        $lines = [];
        while (count($lines) <= $n) {
            try {
                fseek($fp, -$pos, SEEK_END);
            } catch (Exception $e) {
                fseek(0);
                break;
            }
            $pos *= $base;
            while (!feof($fp)) {
                array_unshift($lines, fgets($fp));
            }
        }

        return array_slice($lines, 0, $n);
    }
}
