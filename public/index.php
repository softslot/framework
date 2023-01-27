<?php

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

use Fig\Http\Message\StatusCodeInterface;
use Framework\Http\Exception\RequestNotMatchException;
use Framework\Http\ResponseSender;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

### Initialization

$routes = new RouteCollection();

$routes->get('home', '/', function (ServerRequestInterface $request): ResponseInterface {
    $name = $request->getQueryParams()['name'] ?? 'Guest';

    $response = new Response();
    $response->getBody()->write("Hello, {$name}");

    return $response;
});

$routes->get('about', '/about', function (ServerRequestInterface $request): ResponseInterface {
    $response = new Response();
    $response->getBody()->write("I'm a simple site");

    return $response;
});

$routes->get('blog_show', '/blog/{id}', function (ServerRequestInterface $request): ResponseInterface {
    $response = new Response();
    $response->getBody()->write("Blog show");

    return $response;
});

$router = new Router($routes);
$request = ServerRequestFactory::createFromGlobals();
$response = new Response();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }

    $action = $result->getHandler();
    $response = $action($request);
} catch (RequestNotMatchException $e) {
    $response->getBody()->write('Undefined page');
    $response = $response->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
}

# Postprocessing

$response = $response->withHeader('X-Developer', 'Konstantin');

### Sending

$responseSender = new ResponseSender();
$responseSender->send($response);
