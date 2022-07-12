<?php

use Framework\Factory\Error\HtmlErrorFactory;
use Framework\Middleware\Error\ErrorResponseGenerator;

return [
    'dependencies' => [
        'factories' => [
            ErrorResponseGenerator::class => HtmlErrorFactory::class,
        ],
    ],
    'error' => [
        'views' => [
            '403' => 'error/403',
            '404' => 'error/404',
            'error' => 'error/error',
        ],
    ],
    'debug' => false,
];