<?php

declare(strict_types=1);

namespace Framework\Factory;

use Framework\Middleware\Decorator\Auth;
use Psr\Container\ContainerInterface;

class AuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Auth($container->get('config')['auth']['users']);
    }
}
