<?php

declare(strict_types=1);

namespace Framework\Middleware\Error;

use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HtmlResponseGenerator implements ErrorResponseGenerator
{
    /**
     * @var RendererInterface
     */
    private RendererInterface $template;

    /**
     * @var array
     */
    private array $views;

    public function __construct(RendererInterface $template, array $views)
    {
        $this->template = $template;
        $this->views = $views;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $code = Utils::getStatusCode($e, new Response());
        $view = $this->getView($code);

        return new HtmlResponse($this->template->render($view, [
            'exception' => $e,
        ]), $code);
    }

    /**
     * @param $code
     * @return string
     */
    private function getView($code): string
    {
        if (array_key_exists($code, $this->views)) {
            return $this->views[$code];
        }
        return $this->views['error'];
    }
}
