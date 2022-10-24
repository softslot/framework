<?php

namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Framework\Http\Request;

final class RequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $_GET  = [];
        $_POST = [];
    }

    public function testEmpty(): void
    {
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

        $request = new Request();

        $this->assertEquals($data, $request->getQueryParams());
        $this->assertNull($request->getParseBody());
    }

    public function testParseBody(): void
    {
        $_POST = $data = ['title' => 'Title'];

        $request = new Request();

        $this->assertEquals([], $request->getQueryParams());
        $this->assertEquals($data, $request->getParseBody());
    }
}
