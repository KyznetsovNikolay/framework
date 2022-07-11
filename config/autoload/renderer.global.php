<?php

declare(strict_types=1);

use Framework\Template\RendererInterface;
use Framework\Template\Twig\Extension\RouteExtension;
use Framework\Template\Twig\Renderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

return [
    'dependencies' => [
        'factories' => [
            Environment::class => function (ContainerInterface$container) {
                $params = $container->get('config')['twig'];
                $debug = $container->get('config')['debug'];
                $config = [
                    'cache' => $debug ? false : 'var/cache/twig',
                    'auto_reload' => $debug,
                    'strict_variables' => $debug,
                    'debug' => $debug
                ];

                $loader = new FilesystemLoader($params['render_path']);
                $twig = new Environment($loader, $config);

                if ($debug) {
                    $twig->addExtension(new DebugExtension());
                }

                foreach ($params['extensions'] as $extension) {
                    $twig->addExtension($container->get($extension));
                }

                return $twig;
            },

            RendererInterface::class => function (ContainerInterface $container) {
                $params = $container->get('config')['twig'];

                return new Renderer(
                    $container->get(Environment::class),
                    $params['render_extension'],
                );
            },
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
