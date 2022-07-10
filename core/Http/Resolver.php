<?php

declare(strict_types=1);

namespace Framework\Http;

use Framework\Middleware\Exception\UnknownMiddlewareTypeException;
use Framework\Middleware\Pipeline\LazyMiddleware;
use Framework\Middleware\Pipeline\SinglePassMiddlewareDecorator;
use Laminas\Stratigility\Middleware\DoublePassMiddlewareDecorator;
use Laminas\Stratigility\Middleware\RequestHandlerMiddleware;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Resolver
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $responsePrototype;

    /**
     * @param ContainerInterface $container
     * @param ResponseInterface $responsePrototype
     */
    public function __construct(ContainerInterface $container, ResponseInterface $responsePrototype)
    {
        $this->container = $container;
        $this->responsePrototype = $responsePrototype;
    }

    /**
     * @param $handler
     * @return MiddlewareInterface
     */
    public function resolve($handler): MiddlewareInterface
    {
        if (\is_array($handler)) {
            return $this->createPipe($handler);
        }

        if (\is_string($handler) && $this->container->has($handler)) {
            return new LazyMiddleware($this, $this->container, $handler);
        }

        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        if ($handler instanceof RequestHandlerInterface) {
            return new RequestHandlerMiddleware($handler);
        }

        if (\is_object($handler)) {
            $reflection = new \ReflectionObject($handler);
            if ($reflection->hasMethod('__invoke')) {
                $method = $reflection->getMethod('__invoke');
                $parameters = $method->getParameters();
                if (\count($parameters) === 2 && $parameters[1]->isCallable()) {
                    return new SinglePassMiddlewareDecorator($handler);
                }
                return new DoublePassMiddlewareDecorator($handler, $this->responsePrototype);
            }
        }

        throw new UnknownMiddlewareTypeException($handler);
    }

    /**
     * @param array $handlers
     * @return MiddlewarePipe
     */
    private function createPipe(array $handlers): MiddlewarePipe
    {
        $pipeline = new MiddlewarePipe();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }
}
