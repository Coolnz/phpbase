<?php


class WeightedRoundRobin
{
    private static $_weightArray = [];

    private static $_i = -1; //代表上一次选择的服务器
    private static $_gcd; //表示集合S中所有服务器权值的最大公约数
    private static $_cw = 0; //当前调度的权值
    private static $_max;
    private static $_n; //agent个数

    public function init()
    {
    }

    public function initParam(array $weightArray)
    {
        self::$_weightArray = $weightArray;
        self::$_gcd = self::getGcd(self::$_weightArray);
        self::$_max = self::getMaxWeight(self::$_weightArray);
        self::$_n = count($weightArray);
    }

    public function getWeight()
    {
        while (true) {
            self::$_i = ((int) self::$_i + 1) % (int) self::$_n;

            if (0 == self::$_i) {
                self::$_cw = (int) self::$_cw - (int) self::$_gcd;
                if (self::$_cw <= 0) {
                    self::$_cw = (int) self::$_max;

                    if (0 == self::$_cw) {
                        return null;
                    }
                }
            }

            if ((int) (self::$_weightArray[self::$_i]['weight']) >= self::$_cw) {
                return self::$_weightArray[self::$_i]['id'];
            }
        }
    }

    private static function getGcd(array $weightArray)
    {
        $temp = array_shift($weightArray);
        $min = $temp['weight'];
        $status = false;
        foreach ($weightArray as $val) {
            $min = min($val['weight'], $min);
        }

        if (1 == $min) {
            return 1;
        }

        for ($i = $min; $i > 1; --$i) {
            foreach ($weightArray as $val) {
                if (is_int($val['weight'] / $i)) {
                    $status = true;
                } else {
                    $status = false;
                    break;
                }
            }
            if ($status) {
                return $i;
            }

            return 1;
        }
    }

    private static function getMaxWeight(array $weightArray)
    {
        if (empty($weightArray)) {
            return false;
        }
        $temp = array_shift($weightArray);
        $max = $temp['weight'];
        foreach ($weightArray as $val) {
            $max = max($val['weight'], $max);
        }

        return $max;
    }
}

$ass = new WeightedRoundRobin();
dd($ass->getWeight());
