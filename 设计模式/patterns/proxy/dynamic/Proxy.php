<?php

namespace proxy\dynamic;

class Proxy
{
    private $cls;
    private $interface = [];
    private $handler;
    private $reflection;

    /**
     * Proxy constructor.
     */
    private function __construct(\ReflectionClass $reflection, InvocationHandler $handler)
    {
        $this->cls = $reflection->getNamespaceName() . $reflection->getName();
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as &$method) {
            $method = $method->getName();
        }
        unset($method);
        $this->interface = $methods;
        $this->handler = $handler;
        $this->reflection = $reflection;
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, $this->interface)) {
            $this->handler->invoke($this, $name, $arguments);
        }
    }

    public static function newProxyInstance($object, $handler)
    {
        return new self(new \ReflectionObject($object), $handler);
    }

    public static function newProxyClass($class, $handler)
    {
        return new self(new \ReflectionClass($class), $handler);
    }
}
