<?php

namespace DesignPatterns\Structural\DependencyInjection\Tests;

use PHPUnit\Framework\TestCase;
use DesignPatterns\Structural\DependencyInjection\DatabaseConnection;
use DesignPatterns\Structural\DependencyInjection\DatabaseConfiguration;

/**
 * @coversNothing
 */
class DependencyInjectionTest extends TestCase
{
    public function testDependencyInjection()
    {
        $config = new DatabaseConfiguration('localhost', 3306, 'domnikl', '1234');
        $connection = new DatabaseConnection($config);

        $this->assertSame('domnikl:1234@localhost:3306', $connection->getDsn());
    }
}
