<?php

declare(strict_types=1);

namespace Framework;

use Framework\Http\Resolver;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\RouterInterface;
use Framework\Middleware\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application extends Pipeline
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @var callable
     */
    private $default;

    /**
     * @var ServerRequestInterface
     */
    protected ServerRequestInterface $request;

    /**
     * @var RouterInterface
     */
    private RouterInterface $router;

    public function __construct(ServerRequestInterface $request, Resolver $resolver, RouterInterface $router, callable $default)
    {
        parent::__construct();
        $this->resolver = $resolver;
        $this->default = $default;
        $this->request = $request;
        $this->router = $router;
    }

    public function pipe($path, $middleware = null): void
    {
        if (!$middleware) {
            parent::pipe($this->resolver->resolve($path));
        } else {
            $uriPath = substr($this->request->getUri()->getPath(), 1, strlen($path));
            if ($path === $uriPath) {
                parent::pipe($this->resolver->resolve($middleware));
            }
        }
    }

    public function run(ResponseInterface $response): ResponseInterface
    {
        return $this($this->request, $response, $this->default);
    }

    private function route($name, $path, $handler, array $methods, array $options = []): void
    {
        $this->router->addRoute(new RouteData($name, $path, $handler, $methods, $options));
    }

    public function any($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, $options);
    }

    public function get($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['GET'], $options);
    }

    public function post($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['POST'], $options);
    }

    public function put($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PUT'], $options);
    }

    public function patch($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PATCH'], $options);
    }

    public function delete($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['DELETE'], $options);
    }

}
