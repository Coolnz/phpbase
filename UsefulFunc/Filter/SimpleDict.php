<?php

namespace UsefulFunc\Filter;

/**
 * A simple dictionary
 * 使用trie数算法实现"敏感词过滤".
 *
 * 1. prepare a text file, format:
 *   word1<tab>value1
 *   word2<tab>value2
 *   ...
 *
 * 2. make a dictionary file:
 *   SimpleDict::make("text_file_path", "output_dict_path");
 *
 * 3. play with it!
 *  $dict = new SimpleDict("dict_path");
 *  $result = $dict->search("some text here...");
 *
 * $result format:
 *   array(
 *     'word1' => array('value' => 'value1', 'count' => 'count1'),
 *     ...
 *   )
 *
 * @see https://github.com/nowgoo/dict/
 *
 * @author Nowgoo <nowgoo@gmail.com>
 * http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class SimpleDict
{
    /**
     * char for padding value.
     */
    const CHAR_PAD = ' ';

    /**
     * stop chars.
     */
    const CHAR_STOP = ',.? ';

    /**
     * file handle.
     *
     * @var resource
     */
    private $file;

    /**
     * fixed row length.
     *
     * @var int
     */
    private $rowLength = 0;

    /**
     * fixed value length.
     *
     * @var int
     */
    private $valueLength = 0;

    /**
     * first chars cache.
     *
     * @var array
     */
    private $start = [];

    public function __construct($file)
    {
        $this->file = fopen($file, 'r');
        $unpack = unpack('n3', fread($this->file, 6));
        $count = $unpack[1];
        $this->valueLength = $unpack[2];
        $this->rowLength = $unpack[3];
        foreach ($this->readLine(6, $count) as $line) {
            list($fChar, $fCount, $fOffset, $fValue) = $line;
            $this->start[$fChar] = [$fCount, $fOffset, $fValue];
        }
    }

    public function __destruct()
    {
        unset($this->start);
        fclose($this->file);
    }

    /**
     * search $str, return words found in dict:
     * array(
     *   'word1' => array('value' => 'value1', 'count' => 'count1'),
     *   ...
     * ).
     *
     * @param string $str
     *
     * @return array
     */
    public function search($str)
    {
        $ret = [];
        $itr = new CharIterator($str);
        $stops = self::CHAR_STOP;

        $buff = [];

        //		dd(s)
        //
        foreach ($itr as $char) {
            if (false !== mb_strpos($stops, $char)) {
                $buff = [];
                continue;
            }

            foreach ($buff as $prefix => $next) {
                $newPrefix = $prefix . $char;
                list($count, $offset, $value) = $this->findWord($char, $next[0], $next[1]);
                if (!empty($value)) {
                    if (isset($ret[$newPrefix])) {
                        ++$ret[$newPrefix]['count'];
                    } else {
                        $ret[$newPrefix] = [
                            'count' => 1,
                            'value' => $value,
                        ];
                    }
                }
                if ($count > 0) {
                    $buff[$newPrefix] = [$count, $offset];
                }
                unset($buff[$prefix]);
            }
//            dd($this->start[$char]);
//            var_dump($this->start[$char]);die;

            // 如果存在，则
            if (isset($this->start[$char])) {
                list($count, $offset, $value) = $this->start[$char];
                if (!empty($value)) {
                    if (isset($ret[$char])) {
                        ++$ret[$char]['count'];
                    } else {
                        $ret[$char] = [
                            'count' => 1,
                            'value' => $value,
                        ];
                    }
                }
                if ($count > 0 && !isset($buff[$char])) {
                    $buff[$char] = [$count, $offset];
                }
            }
        }
        //		dd($ret);
        return $ret;
    }

    /**
     * replace words to $to
     * if $to is callable, replace to call_user_func($to, $word, $value).
     *
     * @param string $str
     * @param mixed  $to
     *
     * @return string
     */
    public function replace($str, $to)
    {
        $ret = '';
        $itr = new CharIterator($str);
        $stops = self::CHAR_STOP;

        $buff = '';
        $size = 0;
        $offset = 0;
        $buffValue = [];
        foreach ($itr as $char) {
            if (false !== mb_strpos($stops, $char)) {
                if (empty($buffValue)) {
                    $ret .= $buff . $char;
                } else {
                    $ret .= $this->replaceTo($buffValue[0], $buffValue[1], $to)
                        . mb_substr($buff, mb_strlen($buffValue[0])) . $char;
                }
                $buff = '';
                $buffValue = [];

                continue;
            }

            if ('' !== $buff) {
                list($fCount, $fOffset, $fValue) =
                    $this->findWord($char, $size, $offset);
                if (null === $fValue) {
                    if (empty($buffValue)) {
                        $ret .= $buff;
                    } else {
                        $ret .= $this->replaceTo($buffValue[0], $buffValue[1], $to)
                            . mb_substr($buff, mb_strlen($buffValue[0]));
                    }
                    $buff = '';
                    $buffValue = [];
                } else {
                    if ($fCount > 0) {
                        $buff .= $char;
                        $size = $fCount;
                        $offset = $fOffset;
                        if (!empty($fValue)) {
                            $buffValue = [$buff, $fValue];
                        }
                    } else {
                        $ret .= $this->replaceTo($buff . $char, $fValue, $to);
                        $buff = '';
                        $buffValue = [];
                    }
                    continue;
                }
            }

            if (isset($this->start[$char])) {
                list($fCount, $fOffset, $fValue) = $this->start[$char];
                if ($fCount > 0) {
                    $buff = $char;
                    $size = $fCount;
                    $offset = $fOffset;
                    if (!empty($fValue)) {
                        $buffValue = [$buff, $fValue];
                    }
                } else {
                    $ret .= $this->replaceTo($char, $fValue, $to);
                }
            } else {
                $ret .= $char;
            }
        }

        if ('' !== $buff) {
            if (empty($buffValue)) {
                $ret .= $buff;
            } else {
                $ret .= $this->replaceTo($buffValue[0], $buffValue[1], $to) . mb_substr($buff, mb_strlen($buffValue[0]));
            }
        }

        return $ret;
    }

    public function replaceTo($word, $value, $to)
    {
        return is_callable($to)
            ? call_user_func($to, $word, $value)
            : $to;
    }

    /**
     * from $offset, find $char, up to $count record.
     *
     * @param string $char
     * @param int    $count
     * @param int    $offset
     *
     * @return array($count, $offset, $value)
     */
    public function findWord($char, $count, $offset)
    {
        fseek($this->file, $offset);
        $len = $this->rowLength;
        $data = fread($this->file, $count * $len);
        for ($i = 0; $i < $count; ++$i) {
            $row = mb_substr($data, $i * $len, $len);
            $un = unpack('c3char/ncount/Noffset/c*value', $row);
            $fChar = rtrim(chr($un['char1']) . chr($un['char2']) . chr($un['char3']));
            if ($fChar !== $char) {
                continue;
            }
            $fCount = $un['count'];
            $fOffset = $un['offset'];
            $fValue = '';
            for ($j = 1; $j <= $this->rowLength - 9; ++$j) {
                $v = $un['value' . $j];
                if (32 == $v) {
                    break;
                }
                $fValue .= chr($v);
            }

            return [$fCount, $fOffset, $fValue];
        }

        return [0, 0, null];
    }

    /**
     * make a dict file $output from $input.
     *
     * @param string $input
     * @param string $output
     */
    public static function make($input, $output)
    {
        $data = [];
        $fp = fopen($input, 'r');
        $vLen = 0;
        while ($line = fgets($fp, 1024)) {
            list($word, $value) = explode("\t", rtrim($line));
            $itr = new CharIterator($word);
            $pfx = '';
            foreach ($itr as $char) {
                if (!isset($data[$pfx]['next'])
                    || !in_array($char, $data[$pfx]['next'])) {
                    $data[$pfx]['next'][] = $char;
                }
                $pfx .= $char;
            }
            if (mb_strlen($value) > $vLen) {
                $vLen = mb_strlen($value);
            }
            $data[$word]['value'] = $value;
        }
        fclose($fp);

        sort($data['']['next'], SORT_STRING);
        $stack = [array_fill_keys($data['']['next'], 0)];
        $prefix = [];
        $fp = fopen($output, 'w');
        // header: count, valueLength, rowLength
        $line = pack('nnn', count($stack[0]), $vLen, $vLen + 9);
        fwrite($fp, $line);
        $offset = mb_strlen($line);
        do {
            foreach ($stack[0] as $char => &$addr) {
                if ($addr > 0) {
                    continue;
                }
                $line = str_pad($char, 3, self::CHAR_PAD)
                    . pack('nN', 0, 0)
                    . str_repeat(self::CHAR_PAD, $vLen);
                fwrite($fp, $line);
                $addr = $offset;
                $offset += mb_strlen($line);
            }

            $nextKeys = array_keys($stack[0]);
            $nextChar = $nextKeys[0];
            $next = $data[implode('', $prefix) . $nextChar];
            $nextSize = isset($next['next']) ? count($next['next']) : 0;
            $nextVal = isset($next['value']) ? $next['value'] : '';
            $line = pack('nN', $nextSize, $offset)
                . str_pad($nextVal, $vLen, self::CHAR_PAD);
            fseek($fp, $stack[0][$nextChar] + 3);
            fwrite($fp, $line);
            fseek($fp, $offset);
            if (isset($next['next'])) {
                $prefix[] = $nextChar;
                sort($next['next'], SORT_STRING);
                array_unshift($stack, array_fill_keys($next['next'], 0));
            } else {
                unset($stack[0][$nextChar]);
            }

            while (empty($stack[0]) && !empty($stack)) {
                array_shift($stack);
                if (empty($stack)) {
                    break;
                }
                $keys = array_keys($stack[0]);
                unset($stack[0][$keys[0]]);
                array_pop($prefix);
            }
        } while (!empty($stack));
        echo "done\n";
        fclose($fp);
    }

    private function readLine($offset, $size)
    {
        $ret = [];
        fseek($this->file, $offset);
        $data = fread($this->file, $size * $this->rowLength);
        for ($i = 0; $i < $size; ++$i) {
            $row = mb_substr($data, $i * $this->rowLength, $this->rowLength);
            $un = unpack('c3char/ncount/Noffset/c*value', $row);
            $fChar = rtrim(chr($un['char1']) . chr($un['char2']) . chr($un['char3']));
            $fCount = $un['count'];
            $fOffset = $un['offset'];
            $fValue = '';
            for ($j = 1; $j <= $this->rowLength - 9; ++$j) {
                $v = $un['value' . $j];
                if (32 == $v) {
                    break;
                }
                $fValue .= chr($v);
            }
            $ret[] = [$fChar, $fCount, $fOffset, $fValue];
        }

        return $ret;
    }
}
