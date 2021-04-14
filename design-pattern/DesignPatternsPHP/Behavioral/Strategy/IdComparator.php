<?php

namespace DesignPatterns\Behavioral\Strategy;

class IdComparator implements ComparatorInterface
{
    /**
     * @param mixed $a
     * @param mixed $b
     */
    public function compare($a, $b): int
    {
        return $a['id'] <=> $b['id'];
    }
}
