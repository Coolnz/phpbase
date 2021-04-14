<?php

namespace DesignPatterns\Creational\SimpleFactory\Tests;

use PHPUnit\Framework\TestCase;
use DesignPatterns\Creational\SimpleFactory\Bicycle;
use DesignPatterns\Creational\SimpleFactory\SimpleFactory;

/**
 * @coversNothing
 */
class SimpleFactoryTest extends TestCase
{
    public function testCanCreateBicycle()
    {
        $bicycle = (new SimpleFactory())->createBicycle();
        $this->assertInstanceOf(Bicycle::class, $bicycle);
    }
}
