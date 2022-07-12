<?php

declare(strict_types=1);

namespace Framework\Factory;

use Framework\Application;
use Framework\Http\Resolver;
use Framework\Http\Router\Handler\NotFound;
use Framework\Http\Router\RouterInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;

class ApplicationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $request = ServerRequestFactory::fromGlobals();
        return new Application(
            $container->get(MiddlewarePipe::class),
            $request,
            $container->get(Resolver::class),
            $container->get(RouterInterface::class),
            $container->get(NotFound::class)
        );
    }
}
