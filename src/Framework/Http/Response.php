<?php

namespace Framework\Http;

class Response
{
    private string $body;
    private int $statusCode;
    private string $reasonPhrase = '';
    private array $headers = [];

    private static array $reasonPhrases = [
        200 => 'OK',
        301 => 'Moved Permanently',
        400 => 'Bad Request',
        401 => 'Forbidden',
        303 => 'Moved Permanently',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    public function __construct(string $body = '', int $status = 200)
    {
        $this->body = $body;
        $this->statusCode = $status;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function withBody(string $body): self
    {
        $newObj = clone $this;
        $newObj->body = $body;

        return $newObj;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function withStatus(int $status, string $reasonPhrase = ''): self
    {
        $newObj = clone $this;
        $newObj->statusCode = $status;
        $newObj->reasonPhrase = $reasonPhrase;

        return $newObj;
    }

    public function getReasonPhrase()
    {
        if (!$this->reasonPhrase && isset(self::$reasonPhrases[$this->statusCode])) {
            $this->reasonPhrase = self::$reasonPhrases[$this->statusCode];
        }
        return $this->reasonPhrase;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader(string $header): bool
    {
        return isset($this->headers[$header]);
    }

    public function getHeader(string $header): ?string
    {
        if (!$this->hasHeader($header)) {
            return null;
        }

        return $this->headers[$header];
    }

    public function withHeader(string $header, string $value): self
    {
        $newObj = clone $this;

        if ($newObj->hasHeader($header)) {
            unset($newObj->headers[$header]);
        }
        $newObj->headers[$header] = $value;

        return $newObj;
    }
}
