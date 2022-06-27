<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require_once  'vendor/autoload.php';

//$name = '/blog/4/alex';
//if (preg_match('#^/blog/(?P<id>\d+)/(?P<name>[a-z]+)$#i', $name, $matches)) {
//    var_dump($matches);
//} else {
//    echo 'not match' . PHP_EOL;
//}
//die;

### Initialization

$request = ServerRequestFactory::fromGlobals();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse('Hello, ' . $name . '!' . PHP_EOL))
    ->withHeader('X-Developer', 'Kyznetsov');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);


