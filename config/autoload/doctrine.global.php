<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

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
                    'url' => 'mysql://docker:docker@mysql/framework'
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
                    'src/App/Entity'
                ],
            ],
        ],
    ],
];
