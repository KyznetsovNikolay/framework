<?php

declare(strict_types=1);

namespace Framework\Base\Controller;

use Framework\Template\RendererInterface;

class BaseController
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
