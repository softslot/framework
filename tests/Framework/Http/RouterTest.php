<?php

namespace Tests\Framework\Http;

use Framework\Http\Exception\RequestNotMatchException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

class RouterTest extends TestCase
{
    public function testCorrectMethod(): void
    {
        $routes = new RouteCollection();
        $handlerGet = fn () => 'handler_get';
        $handlerPost = fn () => 'handler_post';

        $routes->get($nameGet = 'blog', '/blog', $handlerGet);
        $routes->post($namePost = 'blog_edit', '/blog', $handlerPost);

        $router = new Router($routes);

        $result = $router->match($this->buildRequest('GET', '/blog'));
        $this->assertEquals($nameGet, $result->getName());
        $this->assertEquals($handlerGet, $result->getHandler());

        $result = $router->match($this->buildRequest('POST', '/blog'));
        $this->assertEquals($namePost, $result->getName());
        $this->assertEquals($handlerPost, $result->getHandler());
    }

    public function testMissingMethod(): void
    {
        $routes = new RouteCollection();

        $routes->post('blog', '/blog', fn () => 'handler_post');

        $router = new Router($routes);

        $this->expectException(RequestNotMatchException::class);
        $router->match($this->buildRequest('DELETE', '/blog'));
    }

    public function testCorrectAttributes(): void
    {
        $routes = new RouteCollection();

        $routes->get($name = 'blog_show', '/blog/{id}', fn () => 'handler', ['id' => '\d+']);

        $router = new Router($routes);

        $result = $router->match($this->buildRequest('GET', '/blog/5'));
        $this->assertEquals($name, $result->getName());
        $this->assertEquals(['id' => 5], $result->getAttributes());
    }

    public function testIncorrectedAttributes(): void
    {
        $routes = new RouteCollection();

        $routes->get('blog_show', '/blog/{id}', fn () => 'handler', ['id' => '\d+']);

        $router = new Router($routes);

        $this->expectException(RequestNotMatchException::class);
        $router->match($this->buildRequest('GET', '/blog/slug'));
    }

    public function testGenerate(): void
    {
        $routes = new RouteCollection();

        $routes->get('blog', '/blog', fn () => 'handler');
        $routes->get('blog_show', '/blog/{id}', fn () => 'handler', ['id' => '\d+']);

        $router = new Router($routes);

        $this->assertEquals('/blog', $router->generate('blog'));
        $this->assertEquals('/blog/5', $router->generate('blog_show', ['id' => 5]));
    }

    public function testGenerateMissingAttributes(): void
    {
        $routes = new RouteCollection();

        $routes->get($nameGet = 'blog_show', '/blog/{id}', fn () => 'handler', ['id' => '\d+']);

        $router = new Router($routes);

        $this->expectException(\InvalidArgumentException::class);
        $router->generate($nameGet, ['slug' => 'post']);
    }

    private function buildRequest($method, $uri): RequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $uri);
    }
}
