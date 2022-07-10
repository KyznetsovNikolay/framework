<?php

declare(strict_types=1);

namespace Tests\Core\Middleware\data;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DoublePassMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        if ($request->getAttribute('next')) {
            return $next($request, $response);
        }
        return $response
            ->withHeader('X-Header', $request->getAttribute('attribute'));
    }
}
