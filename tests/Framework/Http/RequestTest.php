<?php

namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Framework\Http\Request;

final class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $_GET = [];
        $_POST = [];

        $request = new Request();

        $this->assertEquals([], $request->getQueryParams());
        $this->assertNull($request->getParseBody());
    }

    public function testQueryParams(): void
    {
        $_GET = $data = [
            'name' => 'Josh',
            'age'  => 28,
        ];
        $_POST = [];

        $request = new Request();

        $this->assertEquals($data, $request->getQueryParams());
        $this->assertNull($request->getParseBody());
    }

    public function testParseBody(): void
    {
        $_GET = [];
        $_POST = $data = ['title' => 'Title'];

        $request = new Request();

        $this->assertEquals([], $request->getQueryParams());
        $this->assertEquals($data, $request->getParseBody());
    }
}
