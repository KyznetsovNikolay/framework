<?php

declare(strict_types=1);

namespace Framework\Http\Router;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class Router implements RouterInterface
{
    /**
     * @var RouteCollection
     */
    private $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate($name, array $params = []): string
    {
        foreach ($this->routes->getRoutes() as $route) {
            if (null !== $url = $route->generate($name, $params)) {
                return $url;
            }
        }

        throw new RouteNotFoundException($name, $params);
    }

    /**
     * stub without implementation
     * not used anywhere yet
     * @param RouteData $data
     */
    public function addRoute(RouteData $data): void {}
}
