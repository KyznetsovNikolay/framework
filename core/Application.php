<?php

declare(strict_types=1);

namespace Framework;

use Framework\Http\Resolver;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\RouterInterface;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Application implements MiddlewareInterface, RequestHandlerInterface
{
    /**
     * @var Resolver
     */
    private Resolver $resolver;

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
     * @var MiddlewarePipe
     */
    private MiddlewarePipe $pipeline;

    /**
     * Application constructor.
     * @param MiddlewarePipe $pipeline
     * @param ServerRequestInterface $request
     * @param Resolver $resolver
     * @param RouterInterface $router
     * @param RequestHandlerInterface $default
     */
    public function __construct(
        MiddlewarePipe $pipeline,
        ServerRequestInterface $request,
        Resolver $resolver,
        RouterInterface $router,
        RequestHandlerInterface $default
    ) {
        $this->resolver = $resolver;
        $this->default = $default;
        $this->request = $request;
        $this->router = $router;
        $this->pipeline = $pipeline;
    }

    /**
     * @param string $path
     * @param string|null $middleware
     */
    public function pipe(string $path, string $middleware = null): void
    {
        if (!$middleware) {
            $this->pipeline->pipe($this->resolver->resolve($path));
        } else {
            $this->pipeline->pipe(new PathMiddlewareDecorator($path, $this->resolver->resolve($middleware)));
        }
    }

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        return $this->handle($this->request);
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

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->pipeline->process($request, $handler);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipeline->process($request, $this->default);
    }
}
