<?php

if (!function_exists('randomCode')) {
    function randomCode(int $num)
    {
        //生成4位随机数，左侧补0
        return str_pad(random_int(1, 999999), $num, 0, STR_PAD_LEFT);
    }
}
