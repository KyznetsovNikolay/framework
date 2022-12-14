<?php

declare(strict_types=1);

namespace Framework\Middleware\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    /**
     * @var \SplQueue
     */
    private \SplQueue $queue;

    public function __construct()
    {
        $this->queue = new \SplQueue();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $delegate = new Next(clone $this->queue, $next);
        return $delegate($request, $response);
    }

    public function pipe($middleware): void
    {
        $this->queue->enqueue($middleware);
    }
}
