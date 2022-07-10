<?php

declare(strict_types=1);

namespace Framework\Middleware\Error;

use Framework\Template\RendererInterface;
use Framework\Utils\Utils;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HtmlResponseGenerator implements ErrorResponseGenerator
{
    /**
     * @var bool
     */
    private bool $debug;

    /**
     * @var RendererInterface
     */
    private RendererInterface $template;

    public function __construct(RendererInterface $template, bool $debug = false)
    {
        $this->debug = $debug;
        $this->template = $template;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->debug ? 'error/debug' : 'error/error';

        return new HtmlResponse($this->template->render($view, [
            'request' => $request,
            'exception' => $e,
        ]), Utils::getStatusCode($e));
    }
}
