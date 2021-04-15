<?php

namespace MagicFunc;

use PHPUnit\Framework\TestCase;

/**
 * [说说 PHP 的魔术方法及其应用 | Laravel China 社区](https://learnku.com/articles/4404/talking-about-the-magic-method-of-php-and-its-application)
 * [私有属性方法 · PHP基础 · 看云](https://www.kancloud.cn/php-development/php-basic/531710).
 *
 * __set() __get() __isset() __unset().
 * [私有属性方法 · PHP基础 · 看云](https://www.kancloud.cn/php-development/php-basic/531710)
 *
 * 1. __set()；方法用于设置私有属性值。（设置一个对象的属性时，若属性存在，则直接返回属性值；若不存在，则会调用 __get函数。）
 * 2. __get()；方法用于获取私有属性值。（ 读取一个对象的属性时，若属性存在，则直接赋值；若不存在，则会调用 __set函数。）
 * 3. __isset()；方法用于检测私有属性值是否被设定。（当对不可访问属性调用 isset() 或 empty() 时，__isset() 会被调用。）
 * 4. __unset()；方法用于删除私有属性。（当对不可访问属性调用 unset() 时，__unset() 会被调用。）
 *
 *
 * Class GetAndSetTest
 *
 * @coversNothing
 */
class GetAndSetTest extends TestCase
{
}

/**
 * @coversNothing
 */
class MethodTest
{
    private $data = [];

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }

    public function testGet()
    {
    }
}
