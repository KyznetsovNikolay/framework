<?php

use Framework\Factory\AuthMiddlewareFactory;
use Framework\Middleware\Decorator\Auth;

return [
    'dependencies' => [
        'factories' => [
            Auth::class => AuthMiddlewareFactory::class,
        ],
    ],
    'auth' => [
        'users' => [],
    ],
];
