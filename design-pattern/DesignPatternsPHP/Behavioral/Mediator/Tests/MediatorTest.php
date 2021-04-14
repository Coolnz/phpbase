<?php

namespace DesignPatterns\Tests\Mediator\Tests;

use PHPUnit\Framework\TestCase;
use DesignPatterns\Behavioral\Mediator\Mediator;
use DesignPatterns\Behavioral\Mediator\Subsystem\Client;
use DesignPatterns\Behavioral\Mediator\Subsystem\Server;
use DesignPatterns\Behavioral\Mediator\Subsystem\Database;

/**
 * @coversNothing
 */
class MediatorTest extends TestCase
{
    public function testOutputHelloWorld()
    {
        $client = new Client();
        new Mediator(new Database(), $client, new Server());

        $this->expectOutputString('Hello World');
        $client->request();
    }
}
