<?php

declare(strict_types=1);

namespace Framework\Middleware\Error;

use Framework\Template\RendererInterface;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HtmlResponseGenerator implements ErrorResponseGenerator
{
    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     * @var array
     */
    private array $views;

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    public function __construct(
        RendererInterface $renderer,
        ResponseInterface $response,
        array $views
    ) {
        $this->renderer = $renderer;
        $this->views = $views;
        $this->response = $response;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $code = Utils::getStatusCode($e, $this->response);

        $response = $this->response->withStatus($code);
        $response
            ->getBody()
            ->write(
                $this->renderer->render(
                    $this->getView($code),
                    [
                        'request' => $request,
                        'exception' => $e,
                    ]
                )
            );

        return $response;
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
