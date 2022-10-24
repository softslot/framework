<?php

namespace Framework\Http;

class Request
{
    private array $queryParams = [];
    private ?array $parsedBody = null;

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams($data): self
    {
        $newObj = clone $this;
        $newObj->queryParams = $data;

        return $newObj;
    }

    public function getParseBody(): ?array
    {
        return $this->parsedBody;
    }

    public function withParsedBody($data): self
    {
        $newObj = clone $this;
        $newObj->parsedBody = $data;

        return $newObj;
    }
}
