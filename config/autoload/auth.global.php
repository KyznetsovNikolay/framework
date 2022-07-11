<?php

use Framework\Middleware\Decorator\Auth;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            Auth::class => function (ContainerInterface $container) {
                return new Auth($container->get('config')['auth']['users']);
            },
        ],
    ],
    'auth' => [
        'users' => [],
    ],
];
