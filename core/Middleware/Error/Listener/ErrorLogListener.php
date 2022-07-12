<?php

declare(strict_types=1);

namespace Framework\Middleware\Error\Listener;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class ErrorLogListener implements ListenerInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Throwable $e
     * @param ServerRequestInterface $request
     * @return void
     */
    public function log(\Throwable $e, ServerRequestInterface $request): void
    {
        $this->logger->error($e->getMessage(), [
            'exception' => $e,
            'request' => $this->extractRequest($request),
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    private function extractRequest(ServerRequestInterface $request): array
    {
        return [
            'method' => $request->getMethod(),
            'url' => (string)$request->getUri(),
            'server' => $request->getServerParams(),
            'cookies' => $request->getCookieParams(),
            'body' => $request->getParsedBody(),
        ];
    }
}
