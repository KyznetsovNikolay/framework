<?php

declare(strict_types=1);

namespace Framework\Factory;

use Framework\Http\Resolver;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

class ResolverFactory
{

    public function __invoke(ContainerInterface $container)
    {
        return new Resolver(
            $container,
            $container->get(Response::class)
        );
    }
}
