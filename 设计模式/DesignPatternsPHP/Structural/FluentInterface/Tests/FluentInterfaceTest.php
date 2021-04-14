<?php

namespace DesignPatterns\Structural\FluentInterface\Tests;

use PHPUnit\Framework\TestCase;
use DesignPatterns\Structural\FluentInterface\Sql;

/**
 * @coversNothing
 */
class FluentInterfaceTest extends TestCase
{
    public function testBuildSQL()
    {
        $query = (new Sql())
                ->select(['foo', 'bar'])
                ->from('foobar', 'f')
                ->where('f.bar = ?');

        $this->assertSame('SELECT foo, bar FROM foobar AS f WHERE f.bar = ?', (string) $query);
    }
}
