<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Framework\Middleware\Error\ErrorResponseGenerator;
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

    public function __construct(ErrorResponseGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            return $this->generator->generate($e, $request);
        }
    }
}
