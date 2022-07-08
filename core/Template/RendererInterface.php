<?php

declare(strict_types=1);

namespace Framework\Template;

interface RendererInterface
{
    /**
     * @param $_view
     * @param array $params
     * @return string
     */
    public function render($_view, array $params = []): string;
}
