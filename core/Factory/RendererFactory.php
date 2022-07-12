<?php

declare(strict_types=1);

namespace Framework\Factory;

use Framework\Template\Twig\Renderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;

class RendererFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $params = $container->get('config')['twig'];

        return new Renderer(
            $container->get(Environment::class),
            $params['render_extension'],
        );
    }
}