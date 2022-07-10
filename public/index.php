<?php

use Framework\Application;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\ServiceManager\ServiceManager;

chdir(dirname(__DIR__));
require_once  'vendor/autoload.php';

/**
 *  @var ServiceManager $container
 *  @var Application $app
 */
$container = require 'config/container.php';
$app = $container->get(Application::class);

require 'config/middleware.php';
require 'config/routes.php';

$response = $app->run();

$emitter = new SapiEmitter();
$emitter->emit($response);


