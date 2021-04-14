<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-22
 * Time: 09:40.
 */
class Circle extends Shape
{
    private $radius = 0;

    public function __construct()
    {
        $this->shapeName = '圆形';

        if ($this->validate($_POST['radius'], '圆的半径')) {
            $this->radius = $_POST['radius'];
        } else {
            exit;
        }
    }

    public function area()
    {
        return pi() * $this->radius * $this->radius;
    }

    public function perimeter()
    {
        return 2 * pi() * $this->radius;
    }
}
