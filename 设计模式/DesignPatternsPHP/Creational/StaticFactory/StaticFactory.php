<?php

namespace DesignPatterns\Creational\StaticFactory;

/**
 * Note1: Remember, static means global state which is evil because it can't be mocked for tests
 * Note2: Cannot be subclassed or mock-upped or have multiple different instances.
 */
final class StaticFactory
{
    public static function factory(string $type): Formatter
    {
        if ('number' == $type) {
            return new FormatNumber();
        } elseif ('string' == $type) {
            return new FormatString();
        }

        throw new \InvalidArgumentException('Unknown format given');
    }
}
