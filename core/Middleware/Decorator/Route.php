<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Result;
use Framework\Http\Router\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Route implements MiddlewareInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {

            $result = $this->router->match($request);
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            return $handler->handle($request->withAttribute(Result::class, $result));

        } catch (RequestNotMatchedException $e){
            return $handler->handle($request);
        }
    }
}
