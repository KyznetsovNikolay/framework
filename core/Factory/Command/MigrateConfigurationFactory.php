<?php

declare(strict_types=1);

namespace Framework\Factory\Command;

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;

class MigrateConfigurationFactory
{
    public function __invoke()
    {
        $configuration = new Configuration();

        $configuration->addMigrationsDirectory('Migrations', 'migrations');
        $configuration->setAllOrNothing(true);
        $configuration->setCheckDatabasePlatform(false);

        $storageConfiguration = new TableMetadataStorageConfiguration();
        $storageConfiguration->setTableName('doctrine_migration_versions');

        $configuration->setMetadataStorageConfiguration($storageConfiguration);

        return $configuration;
    }
}
