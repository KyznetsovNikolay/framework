<?php

declare(strict_types=1);

namespace Framework\Factory\Command;

use Framework\Console\Application;
use Psr\Container\ContainerInterface;

class ApplicationConsoleFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cli = new Application();
        $commands = $container->get('config')['console']['commands'];

        foreach ($commands as $command) {
            $cli->add($container->get($command));
        }

        return $cli;
    }
}
