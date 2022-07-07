<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Credential
{
    /**
     * @var array
     */
    private $headers;

    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $next($request);
        if (count($this->headers)) {
            foreach ($this->headers as $header => $value) {
                $response = $response->withHeader($header, $value);
            }
        }

        return $response;
    }
}
