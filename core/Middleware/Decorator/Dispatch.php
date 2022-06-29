<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Framework\Http\Resolver;
use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

class Dispatch
{
    private $resolver;

    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /** @var Result $result */
        if (!$result = $request->getAttribute(Result::class)) {
            return $next($request);
        }
        $middleware = $this->resolver->resolve($result->getHandler());
        return $middleware($request, $next);
    }
}
