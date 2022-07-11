<?php

use Framework\Middleware\Error\DebugErrorResponseGenerator;
use Framework\Middleware\Error\ErrorResponseGenerator;
use Framework\Middleware\Error\HtmlResponseGenerator;
use Framework\Template\RendererInterface;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            ErrorResponseGenerator::class => function (ContainerInterface $container) {
                if ($container->get('config')['debug']) {
                    return new DebugErrorResponseGenerator(
                        $container->get(RendererInterface::class),
                        'error/debug'
                    );
                }

                $views = $container->get('config')['error']['views'];
                return new HtmlResponseGenerator(
                    $container->get(RendererInterface::class),
                    $views,
                );
            },
        ],
    ],
    'error' => [
        'views' => [
            '403' => 'error/403',
            '404' => 'error/404',
            'error' => 'error/error',
        ],
    ],
];