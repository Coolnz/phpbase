<?php

namespace Packages\Strategy;

//抽象策略类；
interface StrategyInterface
{
    public function do();
}

//具体的策略类；
class StrategyOne implements StrategyInterface
{
    public function do()
    {
        // TODO: Implement do() method.
        echo '选择1：';
    }
}

class StrategyTwo implements StrategyInterface
{
    public function do()
    {
        // TODO: Implement do() method.
        echo '选择2：';
    }
}

//环境类；
class Substance
{
    private $_strategy;

    public function __construct(StrategyInterface $strategy)
    {
        $this->_strategy = $strategy;
    }

    public function doSth()
    {
        $this->_strategy->do();
    }
}

//选择策略1
$substanceOne = new Substance(new StrategyOne());
$substanceOne->doSth();

$substanceTwo = new Substance(new StrategyTwo());
$substanceTwo->doSth();
