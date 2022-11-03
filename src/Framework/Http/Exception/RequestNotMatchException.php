<?php

namespace Framework\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;

class RequestNotMatchException extends \LogicException
{
    private ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct('Matches not found.');
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
