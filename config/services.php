<?php

declare(strict_types=1);

use Aura\Router\RouterContainer;
use Framework\Application;
use Framework\Container\Container;
use Framework\Http\Resolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Handler\NotFound;
use Framework\Http\Router\RouterInterface;
use Framework\Middleware\Decorator\Auth;
use Framework\Middleware\Decorator\Credential;
use Framework\Middleware\Decorator\Dispatch;
use Framework\Middleware\Decorator\Route;
use Framework\Middleware\Decorator\Error;
use Laminas\Diactoros\ServerRequestFactory;

/**
 * @var Container $container
 */
$container->set(Application::class, function (Container $container) {
    $request = ServerRequestFactory::fromGlobals();
    return new Application(
        $request,
        $container->get(Resolver::class),
        $container->get(RouterInterface::class),
        new NotFound()
    );
});

$container->set(Auth::class, function (Container $container) {
    return new Auth($container->get('config')['users']);
});

$container->set(Error::class, function (Container $container) {
    return new Error($container->get('config')['debug']);
});

$container->set(Credential::class, function (Container $container) {
    return new Credential($container->get('config')['headers']);
});

$container->set(Route::class, function (Container $container) {
    return new Route($container->get(RouterInterface::class));
});

$container->set(Dispatch::class, function (Container $container) {
    return new Dispatch($container->get(Resolver::class));
});

$container->set(Resolver::class, function (Container $container) {
    return new Resolver($container);
});

$container->set(RouterInterface::class, function () {
    return new AuraRouterAdapter(new RouterContainer());
});
