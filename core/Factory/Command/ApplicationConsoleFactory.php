<?php

declare(strict_types=1);

namespace Framework\Factory\Command;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\ListCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\RollupCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\SyncMetadataCommand;
use Doctrine\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class ApplicationConsoleFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cli = new Application('Application console');
        $commands = $container->get('config')['console']['commands'];

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);
        $dependencyFactory = $container->get(DependencyFactory::class);

        foreach ($commands as $command) {
            $cli->add($container->get($command));
        }

        $this->addCommands($cli, $dependencyFactory);

        $cli->getHelperSet()->set(
            new EntityManagerHelper(
                $entityManager
            ),
            'em'
        );
        ConsoleRunner::addCommands($cli);
        return $cli;
    }

    private function addCommands(Application $cli, DependencyFactory $dependencyFactory)
    {
        $cli->addCommands([
            new DumpSchemaCommand($dependencyFactory),
            new ExecuteCommand($dependencyFactory),
            new GenerateCommand($dependencyFactory),
            new LatestCommand($dependencyFactory),
            new ListCommand($dependencyFactory),
            new MigrateCommand($dependencyFactory),
            new RollupCommand($dependencyFactory),
            new StatusCommand($dependencyFactory),
            new SyncMetadataCommand($dependencyFactory),
            new VersionCommand($dependencyFactory),
            new DiffCommand($dependencyFactory),
        ]);
    }
}
