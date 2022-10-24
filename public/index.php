<?php

use Framework\Http\RequestFactory;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$request = RequestFactory::fromGlobals();

$name = $request->getQueryParams()['name'] ?? 'Guest';

echo "Hello, {$name}";
