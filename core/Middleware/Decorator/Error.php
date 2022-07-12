<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Framework\Middleware\Error\ErrorResponseGenerator;
use Framework\Middleware\Error\Listener\ListenerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Error implements MiddlewareInterface
{
    /**
     * @var ErrorResponseGenerator
     */
    private ErrorResponseGenerator $generator;

    /**
     * @var ListenerInterface[]
     */
    private array $listeners = [];

    public function __construct(ErrorResponseGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            $this->log($e, $request);
            return $this->generator->generate($e, $request);
        }
    }

    /**
     * @param ListenerInterface $listener
     * @return Error
     */
    public function addListener(ListenerInterface $listener): self
    {
        $this->listeners[] = $listener;
        return $this;
    }

    public function log(\Throwable $e, ServerRequestInterface $request): void
    {
        foreach ($this->listeners as $listener) {
            $listener->log($e, $request);
        }
    }
}
