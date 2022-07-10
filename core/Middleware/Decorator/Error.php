<?php

declare(strict_types=1);

namespace Framework\Middleware\Decorator;

use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Error
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

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        try {
            return $next($request);
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
