<?php

declare(strict_types=1);

use Aura\Router\RouterContainer;
use Framework\Application;
use Framework\Http\Resolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Handler\NotFound;
use Framework\Http\Router\RouterInterface;
use Framework\Middleware\Decorator\Credential;
use Framework\Middleware\Decorator\Dispatch;
use Framework\Middleware\Decorator\Error;
use Framework\Middleware\Decorator\Route;
use Laminas\Diactoros\ServerRequestFactory;
use Framework\Middleware\Decorator\Profiler;
use App\Controller\AboutAction;
use App\Controller\Blog\ShowAction;
use App\Controller\CabinetAction;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'invokables' => [
            Profiler::class,
            App\Controller\IndexAction::class,
            AboutAction::class,
            CabinetAction::class,
            App\Controller\Blog\IndexAction::class,
            ShowAction::class,
        ],
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                $request = ServerRequestFactory::fromGlobals();
                return new Application(
                    $request,
                    $container->get(Resolver::class),
                    $container->get(RouterInterface::class),
                    new NotFound()
                );
            },
            RouterInterface::class => function () {
                return new AuraRouterAdapter(new RouterContainer());
            },
            Resolver::class => function (ContainerInterface $container) {
                return new Resolver($container);
            },
            Error::class => function (ContainerInterface $container) {
                return new Error($container->get('config')['debug']);
            },
            Dispatch::class => function (ContainerInterface $container) {
                return new Dispatch($container->get(Resolver::class));
            },
            Route::class => function (ContainerInterface $container) {
                return new Route($container->get(RouterInterface::class));
            },
            Credential::class => function (ContainerInterface $container) {
                return new Credential($container->get('config')['headers']);
            },
        ],
    ],
];