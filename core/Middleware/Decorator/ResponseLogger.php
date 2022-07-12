<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class ResponseLogger implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        $code = $response->getStatusCode();

        if ($code >= 400 && $code < 600) {
            $this->logger->error($response->getReasonPhrase(), [
                'method' => $request->getMethod(),
                'url' => (string)$request->getUri(),
            ]);
        }

        return $response;
    }
}
