<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-22
 * Time: 09:44.
 */
class Result
{
    private $shape;

    public function __construct()
    {
        switch ($_POST['action']) {
            case 'rect':
                $this->shape = new Rect();
                break;
            case 'triangle':
                $this->shape = new Triangle();
                break;
            case 'circle':
                $this->shape = new Circle();
                break;
            default:
                $this->shape = false;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        if ($this->shape) {
            $result = $this->shape->shapeName . '的周长:' . $this->shape->perimeter() . '<br>';
            $result .= $this->shape->shapeName . '的面积:' . $this->shape->area() . '<br>';

            return $result;
        }

        return '没有这个形状';
    }
}
