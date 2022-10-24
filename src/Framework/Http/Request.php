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
        $this->queryParams = $data;

        return $this;
    }

    public function getParseBody(): ?array
    {
        return $this->parsedBody;
    }

    public function withParsedBody($data): self
    {
        $this->parsedBody = $data;

        return $this;
    }
}
