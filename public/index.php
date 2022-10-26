<?php

use Fig\Http\Message\StatusCodeInterface;
use Framework\Http\ResponseSender;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

### Initialization

$request = ServerRequestFactory::createFromGlobals();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';

$headers = new Headers([
    'X-Developer' => 'Konstantin'
]);
$body = (new StreamFactory())->createStream("Hello, {$name}");

$response = new Response(StatusCodeInterface::STATUS_OK, $headers, $body);

### Sending

$responseSender = new ResponseSender();
$responseSender->send($response);
