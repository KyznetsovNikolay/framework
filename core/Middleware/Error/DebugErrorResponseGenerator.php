<?php

declare(strict_types=1);

namespace Framework\Middleware\Error;

use Framework\Template\RendererInterface;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DebugErrorResponseGenerator implements ErrorResponseGenerator
{
    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     * @var string
     */
    private string $view;

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    public function __construct(
        RendererInterface $renderer,
        ResponseInterface $response,
        string $view
    ) {
        $this->renderer = $renderer;
        $this->view = $view;
        $this->response = $response;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->response->withStatus(Utils::getStatusCode($e, $this->response));

        $response
            ->getBody()
            ->write(
                $this->renderer->render(
                    $this->view,
                    [
                        'request' => $request,
                        'exception' => $e,
                    ]
                )
            );

        return $response;
    }
}
