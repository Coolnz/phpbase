<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible;

use Psr\Http\Message\RequestInterface;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Handler;

class HttpInMemoryCacheHandler extends Handler
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data, Handler $successor = null)
    {
        parent::__construct($successor);

        $this->data = $data;
    }

    /**
     * @return string|null
     */
    protected function processing(RequestInterface $request)
    {
        $key = sprintf(
            '%s?%s',
            $request->getUri()->getPath(),
            $request->getUri()->getQuery()
        );

        if ('GET' == $request->getMethod() && isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }
}
