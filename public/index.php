<?php

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

use Fig\Http\Message\StatusCodeInterface;
use Framework\Http\ResponseSender;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Response;

use function Framework\Utils\isJsonRequest;

### Initialization

$request = ServerRequestFactory::createFromGlobals();

### Preprocessing

if (isJsonRequest($request)) {
    $request = $request->withParsedBody(json_decode($request->getBody()->getContents()));
}

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';
$body = (new StreamFactory())->createStream("Hello, {$name}");
$response = new Response(StatusCodeInterface::STATUS_OK, null, $body);

# Postprocessing

$response = $response->withHeader('X-Developer', 'Konstantin');

### Sending

$responseSender = new ResponseSender();
$responseSender->send($response);
