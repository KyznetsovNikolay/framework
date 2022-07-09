<?php

declare(strict_types=1);

namespace Framework\Template\Twig;

use Framework\Template\RendererInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Renderer implements RendererInterface
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var string
     */
    private string $extension;

    public function __construct(Environment $twig, string $extension)
    {
        $this->twig = $twig;
        $this->extension = $extension;
    }

    /**
     * @param $_view
     * @param array $params
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render($_view, array $params = []): string
    {
        return $this->twig->render($_view . $this->extension, $params);
    }
}