<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Profiler
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $start = microtime(true);

        /** @var ResponseInterface $response */
        $response = $next($request);

        $stop = microtime(true);

        return $response->withHeader('X-Profiler-Time', $stop - $start);
    }
}
