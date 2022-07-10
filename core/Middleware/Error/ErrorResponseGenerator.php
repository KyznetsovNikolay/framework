<?php

declare(strict_types=1);

namespace Framework\Middleware\Error;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ErrorResponseGenerator
{
    /**
     * @param Throwable $e
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function generate(Throwable $e, ServerRequestInterface $request): ResponseInterface;
}
