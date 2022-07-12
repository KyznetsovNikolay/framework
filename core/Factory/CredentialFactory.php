<?php

declare(strict_types=1);

namespace Framework\Factory;

use Framework\Middleware\Decorator\Credential;
use Psr\Container\ContainerInterface;

class CredentialFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Credential($container->get('config')['headers']);
    }
}
