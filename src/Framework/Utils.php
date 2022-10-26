<?php

namespace Framework\Utils;

use Psr\Http\Message\RequestInterface;

function isJsonRequest(RequestInterface $request): bool
{
    return false !== stripos($request->getHeaderLine('Content-Type'), "json");
}
