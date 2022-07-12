<?php

declare(strict_types=1);

namespace Tests\Core\Middleware\Error\data;

use Framework\Middleware\Error\ErrorResponseGenerator;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class DummyGenerator implements ErrorResponseGenerator
{
    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($e->getMessage(), 500);
    }
}
