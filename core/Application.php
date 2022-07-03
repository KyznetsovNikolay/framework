<?php

declare(strict_types=1);

namespace Framework;

use Framework\Http\Resolver;
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

    public function __construct(ServerRequestInterface $request, Resolver $resolver, callable $default)
    {
        parent::__construct();
        $this->resolver = $resolver;
        $this->default = $default;
        $this->request = $request;
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
}
