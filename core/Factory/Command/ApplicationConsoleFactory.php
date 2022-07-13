<?php

declare(strict_types=1);

namespace Framework\Factory\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class ApplicationConsoleFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cli = new Application('Application console');
        $commands = $container->get('config')['console']['commands'];

        foreach ($commands as $command) {
            $cli->add($container->get($command));
        }

        return $cli;
    }
}
