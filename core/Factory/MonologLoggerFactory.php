<?php

declare(strict_types=1);

namespace Framework\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class MonologLoggerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $logger = new Logger('App');
        $logger->pushHandler(new StreamHandler(
            'var/log/app.log',
            $container->get('config')['debug'] ? Logger::DEBUG : Logger::WARNING
        ));
        return $logger;
    }
}
