<?php

namespace DesignPatterns\Structural\Bridge;

abstract class Service
{
    /**
     * @var Formatter
     */
    protected $implementation;

    public function __construct(Formatter $printer)
    {
        $this->implementation = $printer;
    }

    public function setImplementation(Formatter $printer)
    {
        $this->implementation = $printer;
    }

    abstract public function get(): string;
}
