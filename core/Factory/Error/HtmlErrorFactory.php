<?php

declare(strict_types=1);

namespace Framework\Factory\Error;

use Framework\Middleware\Error\HtmlResponseGenerator;
use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

class HtmlErrorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new HtmlResponseGenerator(
            $container->get(RendererInterface::class),
            new Response(),
            $container->get('config')['error']['views'],
        );
    }
}
