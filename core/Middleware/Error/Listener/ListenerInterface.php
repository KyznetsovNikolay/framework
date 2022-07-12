<?php

declare(strict_types=1);

namespace Framework\Middleware\Error\Listener;

use Psr\Http\Message\ServerRequestInterface;

interface ListenerInterface
{
    /**
     * @param \Throwable $e
     * @param ServerRequestInterface $request
     * @return void
     */
    public function set(\Throwable $e, ServerRequestInterface $request): void;
}
