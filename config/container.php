<?php

use Framework\Container\Container;

$container = new Container(require __DIR__ . '/services.php');

$container->set('config', require __DIR__ . '/parameters.php');
$container->setDefaultArguments(require __DIR__ . '/default_arguments.php');

return $container;
