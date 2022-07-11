<?php

declare(strict_types=1);

namespace Framework\Middleware\Error;

use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DebugErrorResponseGenerator implements ErrorResponseGenerator
{
    /**
     * @var RendererInterface
     */
    private RendererInterface $template;

    /**
     * @var string
     */
    private string $view;

    public function __construct(RendererInterface $template, string $view)
    {
        $this->template = $template;
        $this->view = $view;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->template->render($this->view, [
            'exception' => $e,
        ]), Utils::getStatusCode($e, new Response()));
    }
}
