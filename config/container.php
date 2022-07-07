<?php

use Laminas\ServiceManager\ServiceManager;

$config = require __DIR__ . '/config.php';

$container = new ServiceManager($config['dependencies']);

/**
 * Dropped dependencies because they already defined
 * Stay only config parameters
 */
unset($config['dependencies']);
$container->setService('config', $config);

return $container;
