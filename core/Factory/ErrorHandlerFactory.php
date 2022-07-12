<?php

declare(strict_types=1);

namespace Framework\Factory;

use Framework\Middleware\Decorator\Error;
use Framework\Middleware\Error\ErrorResponseGenerator;
use Framework\Middleware\Error\Listener\ErrorLogListener;
use Psr\Container\ContainerInterface;

class ErrorHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $errorHandler =  new Error($container->get(ErrorResponseGenerator::class));
        $errorHandler->addListener($container->get(ErrorLogListener::class));

        return $errorHandler;
    }
}
