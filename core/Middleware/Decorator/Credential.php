<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Credential implements MiddlewareInterface
{
    /**
     * @var array
     */
    private array $headers;

    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if (count($this->headers)) {
            foreach ($this->headers as $header => $value) {
                $response = $response->withHeader($header, $value);
            }
        }

        return $response;
    }
}
