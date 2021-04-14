<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible;

use Psr\Http\Message\RequestInterface;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Handler;

class SlowDatabaseHandler extends Handler
{
    /**
     * @return string|null
     */
    protected function processing(RequestInterface $request)
    {
        // this is a mockup, in production code you would ask a slow (compared to in-memory) DB for the results

        return 'Hello World!';
    }
}
