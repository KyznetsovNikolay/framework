<?php

declare(strict_types=1);

namespace Framework\Middleware\Pipeline;

use Framework\Http\Resolver;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyMiddleware implements MiddlewareInterface
{
    /**
     * @var Resolver
     */
    private Resolver $resolver;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var string
     */
    private string $service;

    public function __construct(Resolver $resolver, ContainerInterface $container, string $service)
    {
        $this->resolver = $resolver;
        $this->container = $container;
        $this->service = $service;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $middleware = $this->resolver->resolve($this->container->get($this->service));
        return $middleware->process($request, $handler);
    }
}
