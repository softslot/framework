<?php

namespace Framework\Http;

class Request
{
    public function getQueryParams()
    {
        return $_GET;
    }

    public function getParseBody()
    {
        return $_POST ?: null;
    }
}
