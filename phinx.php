<?php

use Psr\Container\ContainerInterface;

require 'vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require 'config/container.php';
$config = $container->get('config')['pdo'];

return
[
    'paths' => [
        'migrations' => 'resources/migrations',
        'seeds' => 'resources/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $config['host'],
            'name' => $config['db_name'],
            'user' => $config['user'],
            'pass' => $config['pass'],
            'port' => $config['post'],
        ],
    ],
    'version_order' => 'creation'
];
