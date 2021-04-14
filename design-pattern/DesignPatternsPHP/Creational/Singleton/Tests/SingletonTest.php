<?php

namespace DesignPatterns\Creational\Singleton\Tests;

use PHPUnit\Framework\TestCase;
use DesignPatterns\Creational\Singleton\Singleton;

/**
 * @coversNothing
 */
class SingletonTest extends TestCase
{
    public function testUniqueness()
    {
        $firstCall = Singleton::getInstance();
        $secondCall = Singleton::getInstance();

        $this->assertInstanceOf(Singleton::class, $firstCall);
        $this->assertSame($firstCall, $secondCall);
    }
}
