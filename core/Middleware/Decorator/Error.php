<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Error implements MiddlewareInterface
{
    /**
     * @var bool
     */
    private bool $debug;

    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer, bool $debug = false)
    {
        $this->debug = $debug;
        $this->renderer = $renderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {

            $view = $this->debug ? 'error/debug' : 'error/error';
            return new HtmlResponse($this->renderer->render(
                $view,
                [
                    'exception' => $e,
                ]
            ), $e->getCode() ?: 500);
        }
    }
}
