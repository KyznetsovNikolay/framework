<?php

declare(strict_types=1);

namespace Framework\Base\Controller;

use Framework\Template\RendererInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class BaseController implements RequestHandlerInterface
{
    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render($_path, array $params = []): string
    {
        return $this->renderer->render($_path, $params);
    }
}
