<?php

namespace state;

/**
 * 农民类.
 */
class Farmer
{
    /**
     * 当前季节
     *
     * @var string
     */
    private $_currentSeason = '';

    /**
     * 季节
     *
     * @var string
     */
    private $_season = [
    'spring',
    'summer',
    'autumn',
    'winter',
  ];

    /**
     * 状态
     *
     * @var object
     */
    private $_state;

    /**
     * 设置初始状态
     */
    public function __construct($season = 'spring')
    {
        $this->_currentSeason = $season;
        $this->setState($this->_currentSeason);
    }

    /**
     * 种植.
     *
     * @return string
     */
    public function grow()
    {
        $this->_state->grow();
    }

    /**
     * 收割.
     *
     * @return string
     */
    public function harvest()
    {
        $this->_state->harvest();
        // 设置下一个季节状态
        $this->nextSeason();
    }

    /**
     * 设置状态
     *
     * @param Farm $farm 种植方法
     */
    private function setState($currentSeason)
    {
        if ('spring' === $currentSeason) {
            $this->_state = new FarmSpring();
        }
        if ('summer' === $currentSeason) {
            $this->_state = new FarmSummer();
        }
        if ('autumn' === $currentSeason) {
            $this->_state = new FarmAutumn();
        }
        if ('winter' === $currentSeason) {
            $this->_state = new FarmWinter();
        }
    }

    /**
     * 设置下个季节状态
     */
    private function nextSeason()
    {
        $nowKey = (int) array_search($this->_currentSeason, $this->_season);
        if ($nowKey < 3) {
            $nextSeason = $this->_season[$nowKey + 1];
        } else {
            $nextSeason = 'spring';
        }
        $this->_currentSeason = $nextSeason;
        $this->setState($this->_currentSeason);
    }
}
