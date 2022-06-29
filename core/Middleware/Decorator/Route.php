<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Framework\Http\Resolver;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;

class Route
{
    private $router;
    private $resolver;

    public function __construct(RouterInterface $router, Resolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {

            $result = $this->router->match($request);
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            $middleware = $this->resolver->resolve($result->getHandler());
            return $middleware($request, $next);

        } catch (RequestNotMatchedException $e){
            return $next($request);
        }
    }
}
