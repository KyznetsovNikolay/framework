<?php

declare(strict_types=1);

namespace Framework\Http\Router\Handler;

use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFound implements RequestHandlerInterface
{
    /**
     * @var RendererInterface
     */
    private RendererInterface $template;

    public function __construct(RendererInterface $template)
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->template->render('error/404'), 404);
    }
}
