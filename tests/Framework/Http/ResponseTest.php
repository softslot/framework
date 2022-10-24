<?php

namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Framework\Http\Response;

final class ResponseTest extends TestCase
{
    public function testEmpty(): void
    {
        $response = new Response($body = 'Body');

        $this->assertEquals($body, $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());
    }

    public function test404(): void
    {
        $response = new Response($body = 'Empty', $status = 404);

        $this->assertEquals($body, $response->getBody());
        $this->assertEquals($status, $response->getStatusCode());
        $this->assertEquals('Not Found', $response->getReasonPhrase());
    }

    public function testHeaders(): void
    {
        $response = (new Response(''))
            ->withHeader($name1 = 'X-Header-1', $value1 = 'value_1')
            ->withHeader($name2 = 'X-Header-2', $value2 = 'value_2');

        $expected = [$name1 => $value1, $name2 => $value2];

        $this->assertEquals($expected, $response->getHeaders());
    }
}
