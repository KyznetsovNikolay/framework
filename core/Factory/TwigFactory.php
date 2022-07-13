<?php

declare(strict_types=1);

namespace Framework\Factory;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $params = $container->get('config')['twig'];
        $debug = $container->get('config')['debug'];
        $config = [
            'cache' => $debug ? 'var/cache/twig' : false,
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
    }
}
