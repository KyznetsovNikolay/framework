<?php

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Framework\Factory\Command\MigrateConfigurationFactory;
use Framework\Factory\Command\MigrateDependencyFactory;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

$dbConf = (require 'local.php')['pdo'];
$url = sprintf(
    'mysql://%s:%s@%s/%s',
    $dbConf['user'],
    $dbConf['pass'],
    $dbConf['host'],
    $dbConf['db_name'],
);

return [
    'dependencies' => [
        'factories' => [
            EntityManagerInterface::class => EntityManagerFactory::class,
            Configuration::class => MigrateConfigurationFactory::class,
            DependencyFactory::class => MigrateDependencyFactory::class,
        ]
    ],
    'doctrine_migrations' => [
        'em' => 'default'
    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => $url
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'entities',
                ],
            ],
            'entities' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    'src/Entity'
                ],
            ],
        ],
    ],
];
