<?php

declare(strict_types=1);

namespace Framework;

use Framework\Http\Resolver;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\RouterInterface;
use Framework\Middleware\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application
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

    /**
     * @var Pipeline
     */
    private Pipeline $pipeline;

    /**
     * Application constructor.
     * @param Pipeline $pipeline
     * @param ServerRequestInterface $request
     * @param Resolver $resolver
     * @param RouterInterface $router
     * @param callable $default
     */
    public function __construct(
        Pipeline $pipeline,
        ServerRequestInterface $request,
        Resolver $resolver,
        RouterInterface $router,
        callable $default
    ) {
        $this->resolver = $resolver;
        $this->default = $default;
        $this->request = $request;
        $this->router = $router;
        $this->pipeline = $pipeline;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        return ($this->pipeline)($request, $response, $next);
    }

    /**
     * @param string $path
     * @param string|null $middleware
     */
    public function pipe(string $path, string $middleware = null): void
    {
        if (!$middleware) {
            ($this->pipeline)->pipe($this->resolver->resolve($path));
        } else {
            $uriPath = substr($this->request->getUri()->getPath(), 1, strlen($path));
            if ($path === $uriPath) {
                ($this->pipeline)->pipe($this->resolver->resolve($middleware));
            }
        }
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function run(ResponseInterface $response): ResponseInterface
    {
        return $this($this->request, $response, $this->default);
    }

    /**
     * @param $name
     * @param $path
     * @param $handler
     * @param array $methods
     * @param array $options
     */
    private function route($name, $path, $handler, array $methods, array $options = []): void
    {
        $this->router->addRoute(new RouteData($name, $path, $handler, $methods, $options));
    }

    /**
     * @param $name
     * @param $path
     * @param $handler
     * @param array $options
     */
    public function any($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, $options);
    }

    /**
     * @param $name
     * @param $path
     * @param $handler
     * @param array $options
     */
    public function get($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['GET'], $options);
    }

    /**
     * @param $name
     * @param $path
     * @param $handler
     * @param array $options
     */
    public function post($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['POST'], $options);
    }

    /**
     * @param $name
     * @param $path
     * @param $handler
     * @param array $options
     */
    public function put($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PUT'], $options);
    }

    /**
     * @param $name
     * @param $path
     * @param $handler
     * @param array $options
     */
    public function patch($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PATCH'], $options);
    }

    /**
     * @param $name
     * @param $path
     * @param $handler
     * @param array $options
     */
    public function delete($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['DELETE'], $options);
    }
}
