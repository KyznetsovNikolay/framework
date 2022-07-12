<?php

declare(strict_types=1);

use Framework\Factory\RendererFactory;
use Framework\Factory\TwigFactory;
use Framework\Template\RendererInterface;
use Framework\Template\Twig\Extension\RouteExtension;
use Twig\Environment;

return [
    'dependencies' => [
        'factories' => [
            Environment::class => TwigFactory::class,

            RendererInterface::class => RendererFactory::class,
        ],
    ],
    'twig' => [
        'render_path' => 'resources/views',
        'render_extension' => '.html.twig',
        'extensions' => [
            RouteExtension::class,
        ],
    ]
];
