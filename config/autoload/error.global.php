<?php

use Framework\Middleware\Error\ErrorResponseGenerator;
use Framework\Middleware\Error\HtmlResponseGenerator;
use Framework\Middleware\Error\WhoopsErrorResponseGenerator;
use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Whoops\RunInterface;

return [
    'dependencies' => [
        'factories' => [
            ErrorResponseGenerator::class => function (ContainerInterface $container) {
                if ($container->get('config')['debug']) {
                    return new WhoopsErrorResponseGenerator(
                        $container->get(RunInterface::class),
                        new Response()
                    );
                }

                return new HtmlResponseGenerator(
                    $container->get(RendererInterface::class),
                    new Response(),
                    $container->get('config')['error']['views'],
                );
            },
            RunInterface::class => function () {
                $whoops = new Run();
                $whoops->writeToOutput(false);
                $whoops->allowQuit(false);
                $whoops->pushHandler(new PrettyPageHandler());
                $whoops->register();
                return $whoops;
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