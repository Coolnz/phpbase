<?php

namespace Base\ClassPath;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class ClassTest extends TestCase
{
    public function test1()
    {
        $bear = new Bear('嘉士伯');
        $bear->taste();
        $bear->looks();
        $bear->func();

        $water = new Water('依云', 'Water');
        $water->taste();
        $water->looks();
        $water->func();
    }
}
abstract class Drink
{
    protected $name;
    protected $brand;

    public function __construct($name = '', $brand = '嘉士伯')
    {
        $this->name = $name;
        $this->brand = $brand;
    }

    abstract public function taste();

    //好不好喝

    abstract public function looks();

    //样子

    public function func()
    {
        echo '喝多了难受';
    }
}

class Bear extends Drink
{
    public function taste()
    {
        echo $this->brand . '是' . $this->name . '还算好喝';
    }

    public function looks()
    {
        echo $this->brand . '瓶子不好看';
    }
}

class Water extends Drink
{
    public function taste()
    {
        echo $this->name . '是' . $this->brand . '没味道';
    }

    public function looks()
    {
        echo $this->brand . '瓶子很好看，逼格很高';
    }
}
