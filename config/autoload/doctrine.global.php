<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
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
        ]
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
