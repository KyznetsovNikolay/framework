<?php

declare(strict_types=1);

namespace Framework\Factory\Command;

use Framework\Console\Command\CacheClearCommand;
use Framework\Service\FileManager;
use Psr\Container\ContainerInterface;

class CacheClearCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CacheClearCommand(
            $container->get(FileManager::class),
            $container->get('config')['console']['cachePaths']
        );
    }
}
