<?php

declare(strict_types=1);

namespace Framework\Factory\Error;

use Framework\Middleware\Error\WhoopsErrorResponseGenerator;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Whoops\RunInterface;

class WhoopsErrorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new WhoopsErrorResponseGenerator(
            $container->get(RunInterface::class),
            new Response()
        );
    }
}
