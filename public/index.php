<?php

use Framework\Application;
use Framework\Container\Container;
use Laminas\Diactoros\Response;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require_once  'vendor/autoload.php';

/**
 *  @var Container $container
 *  @var Application $app
 */
$container = require 'config/container.php';
$app = $container->get(Application::class);

require 'config/middleware.php';
require 'config/routes.php';

$response = $app->run(new Response());

$emitter = new SapiEmitter();
$emitter->emit($response);


