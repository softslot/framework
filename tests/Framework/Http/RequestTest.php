<?php

namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Framework\Http\Request;

final class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $request = new Request();

        $this->assertEquals([], $request->getQueryParams());
        $this->assertNull($request->getParseBody());
    }

    public function testQueryParams(): void
    {
        $data = [
            'name' => 'Josh',
            'age'  => 28,
        ];

        $request = (new Request())->withQueryParams($data);

        $this->assertEquals($data, $request->getQueryParams());
        $this->assertNull($request->getParseBody());
    }

    public function testParseBody(): void
    {
        $data = ['title' => 'Title'];

        $request = (new Request())->withParsedBody($data);

        $this->assertEquals([], $request->getQueryParams());
        $this->assertEquals($data, $request->getParseBody());
    }
}
