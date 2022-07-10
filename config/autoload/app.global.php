<?php

declare(strict_types=1);

use Aura\Router\RouterContainer;
use Framework\Application;
use Framework\Http\Resolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Handler\NotFound;
use Framework\Http\Router\RouterInterface;
use Framework\Middleware\Decorator\Credential;
use Framework\Middleware\Decorator\Error;
use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Framework\Middleware\Decorator\Profiler;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'invokables' => [
            Profiler::class,
        ],
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                $request = ServerRequestFactory::fromGlobals();
                return new Application(
                    $container->get(MiddlewarePipe::class),
                    $request,
                    $container->get(Resolver::class),
                    $container->get(RouterInterface::class),
                    $container->get(NotFound::class)
                );
            },
            RouterInterface::class => function () {
                return new AuraRouterAdapter(new RouterContainer());
            },
            Resolver::class => function (ContainerInterface $container) {
                return new Resolver(
                    $container,
                    $container->get(Response::class)
                );
            },
            Error::class => function (ContainerInterface $container) {
                return new Error(
                    $container->get(RendererInterface::class),
                    $container->get('config')['debug']
                );
            },
            Credential::class => function (ContainerInterface $container) {
                return new Credential($container->get('config')['headers']);
            },
        ],
    ],
];
